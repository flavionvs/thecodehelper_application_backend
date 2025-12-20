<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationAttachment;
use App\Models\ApplicationCompletionAttachment;
use App\Models\ApplicationStatus;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiProjectController extends Controller
{
    public function projects(Request $request, $id = null)
    {
        // If an id is provided via route, it is (in your current setup) the route id (my_row_id).
        // Convert it to the business id used by joins (projects.id) for safety.
        $businessId = null;
        if (!empty($id)) {
            [$businessId, $err] = $this->businessProjectIdFromRoute($id);
            if ($err) return $err;
        }

        // Determine relevant project IDs based on role + filter
        if (authUser()->role == 'Client') {
            $project_ids = DB::table('applications')
                ->join('projects', 'projects.id', '=', 'applications.project_id')
                ->where('projects.user_id', authId());
        } else {
            $project_ids = DB::table('applications')
                ->where('applications.user_id', authId());
        }

        if (request()->type == 'ongoing') {
            $project_ids->where(function ($q) {
                $q->where('applications.status', 'Approved')
                    ->orWhere('applications.status', 'Completion Requested');
            });
        } elseif (request()->type == 'cancelled') {
            $project_ids->where('applications.status', 'Cancelled');
        } elseif (request()->type == 'completed') {
            $project_ids->where('applications.status', 'Completed');
        } elseif (request()->type == 'applied') {
            $project_ids->where('applications.status', 'Pending');
        }

        $projectIds = $project_ids->pluck('applications.project_id')->toArray();

        $project = Project::when($businessId, function ($q) use ($businessId) {
                $q->where('projects.id', $businessId);
            })
            ->when(request()->type != 'my-projects' && !$businessId, function ($q) use ($projectIds) {
                if (!empty($projectIds)) {
                    $q->whereIn('projects.id', $projectIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->when(request()->type == 'my-projects' && !$businessId, function ($q) {
                $q->where('projects.user_id', authId());
            })
            ->when(request()->search, function ($q) {
                $q->where('projects.title', 'like', '%' . request()->search . '%');
            })
            ->orderByDesc('projects.id')
            ->paginate(10);

        $data = [];
        $page = page($project);

        foreach ($project as $item) {
            $application = DB::table('applications')
                ->join('projects', 'projects.id', 'applications.project_id')
                ->when(authUser()->role == 'Freelancer', function ($q) {
                    $q->where('applications.user_id', authId());
                })
                ->when(authUser()->role == 'Client', function ($q) {
                    $q->where('projects.user_id', authId());
                })
                ->where('applications.project_id', $item->id)
                ->select('applications.*', 'projects.status as project_status')
                ->first();

            if (!$application && request()->type != 'my-projects') {
                continue;
            }

            $app_status = DB::table('application_statuses')
                ->where('application_id', $application->id ?? null)
                ->where('status', 'Completed')
                ->first();

            $cancelled_status = DB::table('application_statuses')
                ->where('application_id', $application->id ?? null)
                ->where('status', 'Cancelled')
                ->first();

            $completion_request = DB::table('application_statuses')
                ->where('application_id', $application->id ?? null)
                ->where('status', 'Completion Requested')
                ->first();

            $current_status = DB::table('applications')
                ->where('project_id', $item->id)
                ->where('status', '!=', 'Pending')
                ->first();

            $completion_attachment = DB::table('application_completion_attachments')
                ->where('application_id', $application->id ?? null)
                ->get();

            $att = [];
            foreach ($completion_attachment as $ca) {
                $att[] = img($ca->attachment);
            }

            $array = [];
            $array['id'] = $item->id;
            $array['category_id'] = $item->category_id;
            $array['approved_freelancer_id'] = $item->approved_freelancer_id ?? null;
            $array['title'] = $item->title;
            $array['slug'] = $item->slug;
            $array['description'] = $item->description;
            $array['budget'] = $item->budget;
            $array['tags'] = $item->tags;

            $array['status'] = ucfirst($item->status ?? 'pending');
            $array['application_status'] = $current_status->status ?? 'Pending';

            $array['remark'] = $application->remark ?? null;
            $array['completion_attachment'] = $att;

            $array['application'] = isset($item->application) ? ($item->application->count() ?? 0) : 0;

            $array['completed_on'] = $app_status && $app_status->created_at ? timeFormat($app_status->created_at) : null;
            $array['cancelled_at'] = $cancelled_status && $cancelled_status->created_at ? timeFormat($cancelled_status->created_at) : null;
            $array['completion_request'] = $completion_request && $completion_request->created_at ? timeFormat($completion_request->created_at) : null;

            if (!$businessId) {
                $array['category'] = $item->category->name ?? null;
                $array['created_at'] = dateFormat($item->created_at);
            }

            $data[] = $array;
        }

        return response()->json([
            'status' => true,
            'message' => 'Projects fetched successfully!',
            'page' => $page,
            'data' => $data,
        ]);
    }

    public function edit($id)
    {
        // $id is route id (my_row_id). Convert to business id for consistency.
        [$businessId, $err] = $this->businessProjectIdFromRoute($id);
        if ($err) return $err;

        $project = Project::where('user_id', authId())->where('id', $businessId)->first();

        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found',
                'data' => null,
            ], 404);
        }

        $data = [];
        $data['id'] = $project->id;
        $data['category_id'] = $project->category_id;
        $data['title'] = $project->title;
        $data['slug'] = $project->slug;
        $data['description'] = $project->description;
        $data['budget'] = $project->budget;
        $data['tags'] = $project->tags;
        $data['status'] = $project->status;

        return response()->json([
            'status' => true,
            'message' => 'Projects fetched successfully!',
            'data' => $data,
        ]);
    }

    public function ongoingProjects()
    {
        $project = Project::where('projects.user_id', authId())
            ->join('applications', 'applications.project_id', 'projects.id')
            ->where('applications.status', 'Approved')
            ->groupBy('projects.id')
            ->orderByDesc('applications.created_at')
            ->select('projects.*', DB::raw('(SELECT COUNT(id) FROM applications WHERE project_id = projects.id) as application_count'))
            ->paginate(10);

        $data = [];
        $page = page($project);

        if ($project) {
            foreach ($project as $item) {
                $array = [];
                $array['id'] = $item->id;
                $array['category_id'] = $item->category_id;
                $array['title'] = $item->title;
                $array['slug'] = $item->slug;
                $array['description'] = $item->description;
                $array['budget'] = $item->budget;
                $array['application'] = $item->application_count;
                $array['attachment'] = $item->attachment;
                $array['category'] = $item->category->name ?? 0;
                $array['created_at'] = dateFormat($item->created_at);
                $data[] = $array;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Projects fetched successfully!',
            'page' => $page,
            'data' => $data,
        ]);
    }

    public function create()
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'slug' => 'required|unique:projects,slug',
                'description' => 'required',
                'category_id' => 'nullable|exists:categories,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => validationError($validator),
                ]);
            }

            $req = request()->except('attachment', 'completed_on', 'completion_request');
            $req['user_id'] = authId();

            $req['status'] = 'pending';
            $req['payment_status'] = 'unpaid';
            $req['selected_application_id'] = null;

            if (request()->attachment) {
                $req['attachment'] = fileSave(request()->attachment, 'upload/project');
            }

            $project = Project::create($req);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Projects created successfully!',
                'data' => [
                    'id' => $project->id,
                    'status' => $project->status,
                    'payment_status' => $project->payment_status,
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => showError($e),
            ]);
        }
    }

    public function update($id)
    {
        // $id is route id (my_row_id). Convert to business id.
        [$businessId, $err] = $this->businessProjectIdFromRoute($id);
        if ($err) return $err;

        DB::beginTransaction();

        try {
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'slug' => 'required|unique:projects,slug,' . $businessId,
                'description' => 'required',
                'category_id' => 'required|exists:categories,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => validationError($validator),
                ]);
            }

            $req = request()->except('attachment', 'completed_on', 'completion_request', 'cancelled_at');

            if (request()->attachment) {
                $req['attachment'] = fileSave(request()->attachment, 'upload/project');
            }

            $project = Project::where('user_id', authId())->where('id', $businessId)->first();
            if (!$project) {
                return response()->json([
                    'status' => false,
                    'message' => 'Project not found',
                ], 404);
            }

            $project->update($req);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Projects updated successfully!',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => showError($e),
            ]);
        }
    }

    public function delete($id)
    {
        // $id is route id (my_row_id). Convert to business id.
        [$businessId, $err] = $this->businessProjectIdFromRoute($id);
        if ($err) return $err;

        DB::beginTransaction();

        try {
            $project = Project::where('id', $businessId)->first();
            if ($project) {
                $project->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Projects deleted successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => showError($e),
            ]);
        }
    }

    /**
     * IMPORTANT:
     * Route passes my_row_id, but applications.project_id stores projects.id (business id).
     */
    public function apply($project_id)
    {
        [$businessProjectId, $err] = $this->businessProjectIdFromRoute($project_id);
        if ($err) return $err;

        $validator = Validator::make(request()->all(), [
            'hours' => 'required',
            'rate' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => validationError($validator),
            ]);
        }

        // Fetch project by business id (joins/relationships rely on projects.id)
        $project = Project::where('id', $businessProjectId)->first();
        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found',
            ], 404);
        }

        $applied = Application::where('project_id', $businessProjectId)
            ->where('user_id', authId())
            ->first();

        if ($applied) {
            return response()->json(['status' => false, 'message' => 'Already applied!']);
        }

        if (authUser()->role == 'Client') {
            return response()->json(['status' => false, 'message' => 'Only freelancer can apply!']);
        }

        if ((int)$project->user_id === (int)authId()) {
            return response()->json(['status' => false, 'message' => 'You can not apply your own project!']);
        }

        $amount = request()->hours * request()->rate;
        $admin_commission = 25; // %
        $admin_amount = $admin_commission * $amount / 100;
        $stripe_commission = 2.6; // %
        $stripe_amount = $stripe_commission * $amount / 100;
        $stripe_fee = 0.3; // currency
        $total_amount = $amount + $admin_amount + $stripe_amount + $stripe_fee;

        $application = Application::create([
            'user_id' => authId(),
            'project_id' => $businessProjectId,
            'hours' => request()->hours,
            'rate' => request()->rate,
            'description' => request()->description,
            'amount' => $amount,
            'admin_commission' => $admin_commission,
            'admin_amount' => $admin_amount,
            'stripe_commission' => $stripe_commission,
            'stripe_amount' => $stripe_amount,
            'stripe_fee' => $stripe_fee,
            'total_amount' => $total_amount,
            'project_data' => $project,
            'user_data' => User::where('id', authId())
                ->select('users.first_name', 'users.email', 'users.first_name', 'users.phone')
                ->first(),
            'status' => 'Pending',
        ]);

        if (request()->attachments) {
            foreach (request()->attachments as $attachment) {
                ApplicationAttachment::create([
                    'application_id' => $application->id,
                    'attachment' => fileSave($attachment, 'upload/application'),
                ]);
            }
        }

        Notification::create([
            'user_id' => authId(),
            'title' => 'New project application',
            'message' => 'You have a new project application',
        ]);

        Notification::create([
            'user_id' => $application->project->user_id,
            'title' => 'You have a new project application.',
            'message' => 'You have a new project application',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Application submitted successfully!',
        ]);
    }

    public function application($project_id)
    {
        [$businessProjectId, $err] = $this->businessProjectIdFromRoute($project_id);
        if ($err) return $err;

        $applications = Application::whereHas('project', function ($q) {
                $q->where('user_id', authId());
            })
            ->where('project_id', $businessProjectId)
            ->select('applications.*')
            ->orderByDesc('id')
            ->paginate(10);

        $data = [];
        $page = page($applications);

        if ($applications) {
            foreach ($applications as $item) {
                $array = [];
                $array['id'] = $item->id;
                $array['user_id'] = $item->user_id;
                $array['username'] = $item->user->first_name;
                $array['status'] = $item->status;
                $array['description'] = $item->description;
                $array['hours'] = $item->hours;
                $array['rate'] = $item->rate;
                $array['amount'] = $item->amount;
                $array['admin_commission'] = $item->admin_commission;
                $array['admin_amount'] = $item->admin_amount;
                $array['stripe_commission'] = $item->stripe_commission;
                $array['stripe_amount'] = $item->stripe_amount;
                $array['stripe_fee'] = $item->stripe_fee;
                $array['total_amount'] = $item->total_amount;
                $array['attachments'] = $item->attachments->map(function ($attachment) {
                    return img($attachment->attachment);
                })->toArray();
                $array['date_and_time'] = timeFormat($item->created_at);
                $data[] = $array;
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Applications fetched successfully!',
            'page' => $page,
            'data' => $data,
        ]);
    }

    public function applied($project_id)
    {
        [$businessProjectId, $err] = $this->businessProjectIdFromRoute($project_id);
        if ($err) return $err;

        $applied = Application::where('project_id', $businessProjectId)
            ->where('user_id', authId())
            ->exists();

        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'applied' => $applied ? true : false,
        ]);
    }

    public function updateApplicationStatus()
    {
        DB::beginTransaction();

        try {
            $applied = Application::whereHas('project', function ($q) {
                    $q->where('user_id', authId());
                })
                ->where('id', request()->applicationId)
                ->first();

            if (!$applied) {
                return response()->json([
                    'status' => false,
                    'message' => 'Application not found',
                ], 404);
            }

            $applied->status = 'Approved';
            $applied->save();

            Payment::create([
                'user_id' => authId(),
                'application_id' => request()->applicationId,
                'amount' => (float) request()->amount / 100,
                'paymentDetails' => json_encode(request()->paymentDetails, true),
                'paymentIntentId' => request()->paymentIntentId,
                'paymentStatus' => request()->paymentStatus,
            ]);

            Notification::create([
                'user_id' => $applied->user_id,
                'title' => 'Application approved',
                'message' => 'Your application has been approved',
            ]);

            Notification::create([
                'user_id' => $applied->project->user_id,
                'title' => 'You have a new project application.',
                'message' => 'You have a new project application',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Success!',
                'applied' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function completed($id)
    {
        [$businessProjectId, $err] = $this->businessProjectIdFromRoute($id);
        if ($err) return $err;

        DB::beginTransaction();

        try {
            $validator = Validator::make(request()->all(), [
                'remark' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'data' => validationError($validator),
                ]);
            }

            if (!authUser()->stripe_account_id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please connect your account with stripe first.',
                ]);
            }

            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $account = \Stripe\Account::retrieve(authUser()->stripe_account_id);

            if (
                !authUser()->stripe_account_id ||
                (!isset($account->charges_enabled) || !$account->charges_enabled) ||
                (!isset($account->payouts_enabled) || !$account->payouts_enabled)
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Your Stripe account is not fully verified.',
                ]);
            }

            $application = Application::where('project_id', $businessProjectId)
                ->where('user_id', authId())
                ->where('status', 'Approved')
                ->first();

            if (!$application) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request sent.',
                ]);
            }

            $application->status = 'Completion Requested';
            $application->remark = request()->remark;
            $application->save();

            ApplicationStatus::updateOrCreate([
                'application_id' => $application->id,
                'status' => 'Completion Requested',
            ]);

            if (request()->attachments) {
                foreach (request()->attachments as $attachment) {
                    ApplicationCompletionAttachment::create([
                        'application_id' => $application->id,
                        'attachment' => fileSave($attachment, 'upload/application'),
                    ]);
                }
            }

            Notification::create([
                'user_id' => authId(),
                'title' => 'Project completion request',
                'message' => 'Project completion request sent successfully',
            ]);

            Notification::create([
                'user_id' => $application->project->user_id,
                'title' => 'Project completion request',
                'message' => 'Project completion request sent successfully',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Project completion request sent successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function acceptCompleted($id)
    {
        [$businessProjectId, $err] = $this->businessProjectIdFromRoute($id);
        if ($err) return $err;

        DB::beginTransaction();

        try {
            $application = Application::join('projects', 'projects.id', 'applications.project_id')
                ->where('applications.project_id', $businessProjectId)
                ->where('projects.user_id', authId())
                ->where('applications.status', 'Completion Requested')
                ->select('applications.*')
                ->first();

            if (!$application) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request sent.',
                ]);
            }

            $application->status = 'Completed';
            $application->remark = request()->remark;
            $application->save();

            ApplicationStatus::updateOrCreate([
                'application_id' => $application->id,
                'status' => 'Completed',
            ]);

            $freelancer = User::find($application->user_id);

            $transfer = transfer($freelancer->stripe_account_id, $application->amount);
            if (!$transfer['status']) {
                return response()->json(['status' => false, 'message' => $transfer['message']]);
            }

            Payment::create([
                'application_id' => $application->id,
                'user_id' => $application->user_id,
                'amount' => $application->amount,
                'paymentStatus' => 'succeeded',
                'stripe_transfer_id' => $transfer['stripe_transfer_id'],
            ]);

            Payment::create([
                'application_id' => $application->id,
                'user_id' => authId(),
                'amount' => -$application->amount,
                'paymentStatus' => 'succeeded',
            ]);

            Notification::create([
                'user_id' => $application->user_id,
                'title' => 'Project completion request accepted',
                'message' => 'Project completion request has been accepted successfully',
            ]);

            Notification::create([
                'user_id' => $application->project->user_id,
                'title' => 'Project completion request accepted',
                'message' => 'Project completion request has been accepted successfully',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Project accepted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function cancel($application_id)
    {
        DB::beginTransaction();

        try {
            $application = Application::where('id', $application_id)
                ->select('applications.*')
                ->first();

            if (!$application) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid request sent.',
                ]);
            }

            $application->status = 'Cancelled';
            $application->cancel_reason = request()->cancel_reason;
            $application->save();

            ApplicationStatus::updateOrCreate([
                'application_id' => $application->id,
                'status' => 'Cancelled',
            ]);

            $freelancer_account = User::find($application->user_id);

            $transfer = transfer($freelancer_account->stripe_account_id, $application->total_amount);
            if (!$transfer['status']) {
                return response()->json([
                    'status' => false,
                    'message' => $transfer['message'],
                ]);
            }

            Payment::create([
                'application_id' => $application->id,
                'user_id' => authId(),
                'amount' => -1 * ($application->total_amount * 90 / 100),
                'paymentStatus' => 'succeeded',
                'stripe_transfer_id' => $transfer['stripe_transfer_id'],
            ]);

            Notification::create([
                'user_id' => $application->user_id,
                'title' => 'Project completion cancelled',
                'message' => 'Project completion has been cancelled.',
            ]);

            Notification::create([
                'user_id' => $application->project->user_id,
                'title' => 'Project completion request accepted',
                'message' => 'Project completion request has been accepted successfully',
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Project cancelled successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Converts route project id (my_row_id) -> business id (projects.id)
     * because applications.project_id references projects.id.
     */
    private function businessProjectIdFromRoute($project_id)
    {
        $project = Project::where('my_row_id', $project_id)->first();

        if (!$project) {
            return [null, response()->json([
                'status' => false,
                'message' => 'Project not found',
            ], 404)];
        }

        return [$project->id, null];
    }
}
