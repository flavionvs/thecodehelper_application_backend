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
    /**
     * Resolve project by ID
     */
    private function resolveProject($project_id)
    {
        $project = Project::find($project_id);

        if (!$project) {
            return [null, null, null, response()->json([
                'status' => false,
                'message' => 'Project not found',
            ], 404)];
        }

        // Both businessId and routeId are now the same (id is the only PK)
        $id = (int) $project->id;
        return [$id, $id, $project, null];
    }

    private function projectIdCandidates($businessId, $routeId)
    {
        // Since businessId == routeId now, just return one value
        if (!empty($businessId)) return [(int) $businessId];
        if (!empty($routeId)) return [(int) $routeId];
        return [];
    }

    /**
     * Get application primary key
     */
    private function applicationPk($app)
    {
        return (int) ($app->id ?? 0);
    }

    public function projects(Request $request, $id = null)
    {
        $businessId = null;
        $routeId = null;

        if (!empty($id)) {
            [$businessId, $routeId, $proj, $err] = $this->resolveProject($id);
            if ($err) return $err;
        }

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

        $appProjectIds = $project_ids->pluck('applications.project_id')->toArray();

        // businessId and routeId are now always the same (just id)
        $project = Project::when($businessId, function ($q) use ($businessId) {
                $q->where('projects.id', $businessId);
            })
            ->when(request()->type != 'my-projects' && !$businessId && !$routeId, function ($q) use ($appProjectIds) {
                if (!empty($appProjectIds)) {
                    $q->whereIn('projects.id', $appProjectIds);
                } else {
                    $q->whereRaw('1 = 0');
                }
            })
            ->when(request()->type == 'my-projects' && !$businessId && !$routeId, function ($q) {
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

            $candidateProjectIds = $this->projectIdCandidates($item->id, $item->id);

            // ✅ IMPORTANT: Fetch application only for the current viewer/user
            $applicationQuery = DB::table('applications')
                ->whereIn('applications.project_id', $candidateProjectIds);

            if (authUser()->role == 'Freelancer') {
                $applicationQuery->where('applications.user_id', authId());
            } else {
                // Client
                $applicationQuery->join('projects', 'projects.id', '=', 'applications.project_id')
                    ->where('projects.user_id', authId())
                    ->select('applications.*', 'projects.status as project_status');
            }

            $application = $applicationQuery->first();

            // For non "my-projects" view, if no application exists then skip
            if (!$application && request()->type != 'my-projects') {
                continue;
            }

            // ✅ Use real PK for all status/attachments tables
            $applicationPk = $application ? $this->applicationPk($application) : 0;

            $app_status = DB::table('application_statuses')
                ->where('application_id', $applicationPk ?: null)
                ->where('status', 'Completed')
                ->first();

            $cancelled_status = DB::table('application_statuses')
                ->where('application_id', $applicationPk ?: null)
                ->where('status', 'Cancelled')
                ->first();

            $completion_request = DB::table('application_statuses')
                ->where('application_id', $applicationPk ?: null)
                ->where('status', 'Completion Requested')
                ->first();

            $current_status = DB::table('applications')
                ->whereIn('project_id', $candidateProjectIds)
                ->where('status', '!=', 'Pending')
                ->first();

            $completion_attachment = DB::table('application_completion_attachments')
                ->where('application_id', $applicationPk ?: null)
                ->get();

            $att = [];
            foreach ($completion_attachment as $ca) {
                $att[] = img($ca->attachment);
            }

            $array = [];
            $array['id'] = $item->id;
            $array['route_id'] = $item->id;
            $array['applied'] = Application::whereIn('project_id', $candidateProjectIds)->where('user_id', authId())->exists();
            $array['category_id'] = $item->category_id;
            $array['title'] = $item->title;
            $array['slug'] = $item->slug;
            $array['description'] = $item->description;
            $array['budget'] = $item->budget;
            $array['tags'] = $item->tags;

            $array['status'] = ucfirst($item->status ?? 'pending');
            $array['application_status'] = $current_status->status ?? 'Pending';

            // ✅ Chat user ID: For clients, show the approved freelancer. For freelancers, show the client.
            if (authUser()->role == 'Client') {
                // Get approved freelancer's user_id
                $approvedApp = DB::table('applications')
                    ->whereIn('project_id', $candidateProjectIds)
                    ->where(function($q) {
                        $q->where('status', 'Approved')
                          ->orWhere('status', 'Completion Requested');
                    })
                    ->first();
                $array['chat_user_id'] = $approvedApp->user_id ?? null;
            } else {
                // Freelancer sees the project owner (client)
                $array['chat_user_id'] = $item->user_id;
            }

            $array['remark'] = $application->remark ?? null;
            $array['completion_attachment'] = $att;

            $array['application'] = isset($item->application) ? ($item->application->count() ?? 0) : 0;

            $array['completed_on'] = $app_status && $app_status->created_at ? timeFormat($app_status->created_at) : null;
            $array['cancelled_at'] = $cancelled_status && $cancelled_status->created_at ? timeFormat($cancelled_status->created_at) : null;
            $array['completion_request'] = $completion_request && $completion_request->created_at ? timeFormat($completion_request->created_at) : null;

            if (!$businessId && !$routeId) {
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
        [$businessId, $routeId, $project, $err] = $this->resolveProject($id);
        if ($err) return $err;

        $project = Project::where('user_id', authId())
            ->where('id', $businessId)
            ->first();

        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'Project not found',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Projects fetched successfully!',
            'data' => [
                'id' => $project->id,
                'category_id' => $project->category_id,
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'budget' => $project->budget,
                'tags' => $project->tags,
                'status' => $project->status,
            ],
        ]);
    }

    public function ongoingProjects()
    {
        $project = Project::where('projects.user_id', authId())
            ->join('applications', 'applications.project_id', '=', 'projects.id')
            ->where('applications.status', 'Approved')
            ->groupBy('projects.id')
            ->orderByDesc('applications.created_at')
            ->select('projects.*', DB::raw('(SELECT COUNT(id) FROM applications WHERE project_id = projects.id) as application_count'))
            ->paginate(10);

        $data = [];
        $page = page($project);

        if ($project) {
            foreach ($project as $item) {
                $data[] = [
                    'id' => $item->id,
                    'category_id' => $item->category_id,
                    'title' => $item->title,
                    'slug' => $item->slug,
                    'description' => $item->description,
                    'budget' => $item->budget,
                    'application' => $item->application_count,
                    'attachment' => $item->attachment,
                    'category' => $item->category->name ?? 0,
                    'created_at' => dateFormat($item->created_at),
                ];
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

            /**
             * ✅ BRIDGE FIX (kept from your version):
             * If id is missing/0 but we have id, set id to id.
             */
            $routeId = $project->id ?? null;

            if ($routeId && (empty($project->id) || (int)$project->id === 0)) {
                DB::table('projects')
                    ->where('id', $routeId)
                    ->update(['id' => $routeId]);

                $project->id = $routeId;
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Projects created successfully!',
                'data' => [
                    'id' => $project->id,
                    'route_id' => $project->id,
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
        [$businessId, $routeId, $proj, $err] = $this->resolveProject($id);
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

            $project = Project::where('user_id', authId())
                ->where('id', $businessId)
                ->first();

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
        [$businessId, $routeId, $proj, $err] = $this->resolveProject($id);
        if ($err) return $err;

        DB::beginTransaction();

        try {
            $project = Project::find($businessId);

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

    public function apply($project_id)
    {
        [$businessProjectId, $routeProjectId, $project, $err] = $this->resolveProject($project_id);
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

        $candidateProjectIds = $this->projectIdCandidates($businessProjectId, $routeProjectId);

        $alreadyApplied = Application::whereIn('project_id', $candidateProjectIds)
            ->where('user_id', authId())
            ->exists();

        if ($alreadyApplied) {
            return response()->json(['status' => false, 'message' => 'Already applied!']);
        }

        if (authUser()->role == 'Client') {
            return response()->json(['status' => false, 'message' => 'Only freelancer can apply!']);
        }

        if ((int)$project->user_id === (int)authId()) {
            return response()->json(['status' => false, 'message' => 'You can not apply your own project!']);
        }

        DB::beginTransaction();

        try {
            $amount = request()->hours * request()->rate;
            $admin_commission = 25;
            $admin_amount = $admin_commission * $amount / 100;
            $stripe_commission = 2.6;
            $stripe_amount = $stripe_commission * $amount / 100;
            $stripe_fee = 0.3;
            $total_amount = $amount + $admin_amount + $stripe_amount + $stripe_fee;

            // ✅ Store project_id consistently
            $storeProjectId = $routeProjectId ?: $businessProjectId;

            $application = Application::create([
                'user_id' => authId(),
                'project_id' => $storeProjectId,
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
                'project_data' => json_encode($project),
                'user_data' => User::where('id', authId())
                    ->select('users.first_name', 'users.email', 'users.first_name', 'users.phone')
                    ->first(),
                'status' => 'Pending',
            ]);

            // ✅ IMPORTANT: new PK for attachments/status tables
            $applicationPk = $this->applicationPk($application);

            if (request()->attachments) {
                foreach (request()->attachments as $attachment) {
                    ApplicationAttachment::create([
                        'application_id' => $applicationPk,
                        'attachment' => fileSave($attachment, 'upload/application'),
                    ]);
                }
            }

            // ✅ Notifications must never break apply
            try {
                Notification::create([
                    'user_id' => authId(),
                    'title' => 'New project application',
                    'message' => 'You have a new project application',
                    'type' => 'application',
                    'link' => '/dashboard?tab=applications',
                    'reference_id' => $storeProjectId,
                ]);

                Notification::create([
                    'user_id' => $project->user_id,
                    'title' => 'You have a new project application.',
                    'message' => 'You have a new project application',
                    'type' => 'application',
                    'link' => '/dashboard?tab=ongoing',
                    'reference_id' => $storeProjectId,
                ]);
            } catch (\Throwable $e) {
                \Log::error('Apply notification failed: ' . $e->getMessage(), [
                    'project_id' => $storeProjectId,
                    'freelancer_id' => authId(),
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Application submitted successfully!',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            \Log::error('Apply failed: ' . $e->getMessage(), [
                'project_id' => $project_id,
                'freelancer_id' => authId(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Server Error',
            ], 500);
        }
    }

    public function application($project_id)
    {
        [$businessProjectId, $routeProjectId, $project, $err] = $this->resolveProject($project_id);
        if ($err) return $err;

        $candidateProjectIds = $this->projectIdCandidates($businessProjectId, $routeProjectId);

        // Get applications for project
        $applications = Application::join('projects', 'projects.id', '=', 'applications.project_id')
            ->where('projects.user_id', authId())
            ->whereIn('applications.project_id', $candidateProjectIds)
            ->select('applications.*')
            ->orderByDesc('applications.id')
            ->paginate(10);

        $data = [];
        $page = page($applications);

        foreach ($applications as $item) {
            $appPk = $this->applicationPk($item);

            $data[] = [
                // ✅ legacy field kept, but DO NOT use it for payments anymore
                'id' => $item->id,

                // ✅ this is what frontend must use
                'id' => $item->id,

                // ✅ optional: helpful for debugging
                'application_pk' => $appPk,

                'user_id' => $item->user_id,
                'username' => $item->user->first_name ?? null,
                'status' => $item->status,
                'description' => $item->description,
                'hours' => $item->hours,
                'rate' => $item->rate,
                'amount' => $item->amount,
                'admin_commission' => $item->admin_commission,
                'admin_amount' => $item->admin_amount,
                'stripe_commission' => $item->stripe_commission,
                'stripe_amount' => $item->stripe_amount,
                'stripe_fee' => $item->stripe_fee,
                'total_amount' => $item->total_amount,
                'attachments' => $item->attachments ? $item->attachments->map(function ($attachment) {
                    return img($attachment->attachment);
                })->toArray() : [],
                'date_and_time' => timeFormat($item->created_at),
            ];
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
        [$businessProjectId, $routeProjectId, $project, $err] = $this->resolveProject($project_id);
        if ($err) return $err;

        $candidateProjectIds = $this->projectIdCandidates($businessProjectId, $routeProjectId);

        $exists = Application::whereIn('project_id', $candidateProjectIds)
            ->where('user_id', authId())
            ->exists();

        return response()->json([
            'status' => true,
            'message' => 'Success!',
            'applied' => $exists ? true : false,
        ]);
    }

    /**
     * ✅ UPDATED: this is the endpoint your current flow likely uses (NOT webhook)
     * Route: POST api/update-application-status
     *
     * Fixes:
     * - Adds logs so you can prove it's being called
     * - Idempotent Payment create by paymentIntentId
     * - Amount supports cents OR dollars
     * - Always flips Project -> paid + in_progress + selected_application_id
     */
    public function updateApplicationStatus()
    {
        \Log::info('[updateApplicationStatus] called', [
            'authId' => authId(),
            'role'   => authUser()->role ?? null,
            'payload'=> request()->all(),
        ]);

        DB::beginTransaction();

        try {
            $reqAppId = (int) request()->applicationId;

            if ($reqAppId <= 0) {
                DB::rollBack();
                \Log::warning('[updateApplicationStatus] invalid applicationId', [
                    'applicationId' => request()->applicationId,
                    'payload' => request()->all(),
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid applicationId',
                ], 422);
            }

            // Get application by ID
            $applied = Application::join('projects', 'projects.id', '=', 'applications.project_id')
                ->where('projects.user_id', authId())
                ->where('applications.id', $reqAppId)
                ->select('applications.*')
                ->first();

            if (!$applied) {
                DB::rollBack();
                \Log::warning('[updateApplicationStatus] application not found / not owned by client', [
                    'reqAppId' => $reqAppId,
                    'authId' => authId(),
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Application not found',
                ], 404);
            }

            // ✅ Determine stable PK
            $appPk = $this->applicationPk($applied);
            if ($appPk <= 0) {
                DB::rollBack();
                \Log::error('[updateApplicationStatus] application has no usable PK', [
                    'reqAppId' => $reqAppId,
                    'application' => [
                        'id' => $applied->id ?? null,
                        'id' => $applied->id ?? null,
                        'project_id' => $applied->project_id ?? null,
                    ],
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Application PK invalid',
                ], 500);
            }

            // ✅ Approve application (idempotent)
            if (($applied->status ?? null) !== 'Approved') {
                $applied->status = 'Approved';
                $applied->save();
            }

            // Find project by application's project_id
            $proj = Project::find($applied->project_id);

            if (!$proj) {
                DB::rollBack();
                \Log::error('[updateApplicationStatus] project not found for application', [
                    'appPk' => $appPk,
                    'application_project_id' => $applied->project_id,
                ]);
                return response()->json([
                    'status' => false,
                    'message' => 'Project not found for this application',
                ], 404);
            }

            // ✅ Create/Upsert Payment (idempotent by paymentIntentId when present)
            $paymentIntentId = request()->paymentIntentId ?? null;
            $paymentStatus   = request()->paymentStatus ?? null;

            // amount might arrive in cents OR dollars depending on frontend.
            $rawAmount = request()->amount;
            $amount = 0.0;

            if (is_numeric($rawAmount)) {
                $raw = (float)$rawAmount;
                // heuristic: treat huge numbers as cents
                $amount = ($raw > 9999) ? ($raw / 100) : $raw;
            }

            if ($paymentIntentId) {
                $existing = Payment::where('paymentIntentId', $paymentIntentId)->first();
                if (!$existing) {
                    Payment::create([
                        'user_id' => authId(),
                        'application_id' => $appPk, // ✅ store stable PK
                        'amount' => number_format((float)$amount, 2, '.', ''),
                        'paymentDetails' => json_encode(request()->paymentDetails, true),
                        'paymentIntentId' => $paymentIntentId,
                        'paymentStatus' => $paymentStatus ?: 'succeeded',
                    ]);
                } else {
                    $existing->paymentStatus = $paymentStatus ?: $existing->paymentStatus;
                    $existing->paymentDetails = json_encode(request()->paymentDetails, true);
                    $existing->save();
                }
            } else {
                Payment::create([
                    'user_id' => authId(),
                    'application_id' => $appPk,
                    'amount' => number_format((float)$amount, 2, '.', ''),
                    'paymentDetails' => json_encode(request()->paymentDetails, true),
                    'paymentIntentId' => null,
                    'paymentStatus' => $paymentStatus ?: 'succeeded',
                ]);
            }

            // ✅ Flip project (THIS is the goal)
            $proj->payment_status = 'paid';
            $proj->status = 'in_progress';
            $proj->selected_application_id = $appPk; // ✅ always stable id
            $proj->save();

            // ✅ Notifications should never break flow
            try {
                Notification::create([
                    'user_id' => $applied->user_id,
                    'title' => 'Application approved',
                    'message' => 'Your application has been approved',
                    'type' => 'project',
                    'link' => '/dashboard?tab=ongoing',
                    'reference_id' => $proj->id,
                ]);

                Notification::create([
                    'user_id' => $proj->user_id,
                    'title' => 'Payment received',
                    'message' => 'Project moved to in progress.',
                    'type' => 'project',
                    'link' => '/dashboard?tab=ongoing',
                    'reference_id' => $proj->id,
                ]);
            } catch (\Throwable $e) {
                \Log::error('[updateApplicationStatus] notification failed: ' . $e->getMessage());
            }

            DB::commit();

            \Log::info('[updateApplicationStatus] success', [
                'appPk' => $appPk,
                'project_id' => $proj->id ?? null,
                'project_id' => $proj->id ?? null,
                'paymentIntentId' => $paymentIntentId,
            ]);

            return response()->json(['status' => true, 'message' => 'Success!', 'applied' => true]);

        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('[updateApplicationStatus] exception', [
                'error' => $e->getMessage(),
                'trace' => substr($e->getTraceAsString(), 0, 1500),
            ]);
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function completed($id)
    {
        [$businessProjectId, $routeProjectId, $project, $err] = $this->resolveProject($id);
        if ($err) return $err;

        $candidateProjectIds = $this->projectIdCandidates($businessProjectId, $routeProjectId);

        DB::beginTransaction();

        try {
            $validator = Validator::make(request()->all(), [
                'remark' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validation error', 'data' => validationError($validator)]);
            }

            if (!authUser()->stripe_account_id) {
                return response()->json(['status' => false, 'message' => 'Please connect your account with stripe first.']);
            }

            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $account = \Stripe\Account::retrieve(authUser()->stripe_account_id);

            if (
                !authUser()->stripe_account_id ||
                (!isset($account->charges_enabled) || !$account->charges_enabled) ||
                (!isset($account->payouts_enabled) || !$account->payouts_enabled)
            ) {
                return response()->json(['status' => false, 'message' => 'Your Stripe account is not fully verified.']);
            }

            $application = Application::whereIn('project_id', $candidateProjectIds)
                ->where('user_id', authId())
                ->where('status', 'Approved')
                ->first();

            if (!$application) {
                return response()->json(['status' => false, 'message' => 'Invalid request sent.']);
            }

            $appPk = $this->applicationPk($application);

            // Use direct DB update to avoid INVISIBLE id column issues with Eloquent save()
            DB::table('applications')
                ->where('id', $appPk)
                ->update([
                    'status' => 'Completion Requested',
                    'remark' => request()->remark,
                    'updated_at' => now(),
                ]);

            ApplicationStatus::updateOrCreate([
                'application_id' => $appPk,
                'status' => 'Completion Requested',
            ]);

            if (request()->attachments) {
                foreach (request()->attachments as $attachment) {
                    ApplicationCompletionAttachment::create([
                        'application_id' => $appPk,
                        'attachment' => fileSave($attachment, 'upload/application'),
                    ]);
                }
            }

            Notification::create([
                'user_id' => authId(),
                'title' => 'Project completion request',
                'message' => 'Project completion request sent successfully',
                'type' => 'completion',
                'link' => '/dashboard?tab=ongoing',
                'reference_id' => $project->id,
            ]);

            Notification::create([
                'user_id' => $project->user_id,
                'title' => 'Project completion request',
                'message' => 'A freelancer has requested project completion',
                'type' => 'completion',
                'link' => '/dashboard?tab=ongoing',
                'reference_id' => $project->id,
            ]);

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Project completion request sent successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function acceptCompleted($id)
    {
        [$businessProjectId, $routeProjectId, $project, $err] = $this->resolveProject($id);
        if ($err) return $err;

        $candidateProjectIds = $this->projectIdCandidates($businessProjectId, $routeProjectId);

        DB::beginTransaction();

        try {
            $application = Application::join('projects', 'projects.id', '=', 'applications.project_id')
                ->whereIn('applications.project_id', $candidateProjectIds)
                ->where('projects.user_id', authId())
                ->where('applications.status', 'Completion Requested')
                ->select('applications.*')
                ->first();

            if (!$application) {
                return response()->json(['status' => false, 'message' => 'Invalid request sent.']);
            }

            $appPk = $this->applicationPk($application);

            // Use direct DB update to avoid INVISIBLE id column issues with Eloquent save()
            DB::table('applications')
                ->where('id', $appPk)
                ->update([
                    'status' => 'Completed',
                    'remark' => request()->remark,
                    'updated_at' => now(),
                ]);

            // Update project status to completed
            DB::table('projects')
                ->where('id', $project->id)
                ->update([
                    'status' => 'completed',
                    'updated_at' => now(),
                ]);

            ApplicationStatus::updateOrCreate([
                'application_id' => $appPk,
                'status' => 'Completed',
            ]);

            $freelancer = User::find($application->user_id);

            $transfer = transfer($freelancer->stripe_account_id, $application->amount);
            if (!$transfer['status']) {
                return response()->json(['status' => false, 'message' => $transfer['message']]);
            }

            Payment::create([
                'application_id' => $appPk,
                'user_id' => $application->user_id,
                'amount' => $application->amount,
                'paymentStatus' => 'succeeded',
                'stripe_transfer_id' => $transfer['stripe_transfer_id'],
            ]);

            Payment::create([
                'application_id' => $appPk,
                'user_id' => authId(),
                'amount' => -$application->amount,
                'paymentStatus' => 'succeeded',
            ]);

            Notification::create([
                'user_id' => $application->user_id,
                'title' => 'Project completion request accepted',
                'message' => 'Project completion request has been accepted successfully',
                'type' => 'completed',
                'link' => '/dashboard?tab=completed',
                'reference_id' => $project->id,
            ]);

            Notification::create([
                'user_id' => $project->user_id,
                'title' => 'Project completion request accepted',
                'message' => 'Project completion request has been accepted successfully',
                'type' => 'completed',
                'link' => '/dashboard?tab=completed',
                'reference_id' => $project->id,
            ]);

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Project accepted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function cancel($application_id)
    {
        DB::beginTransaction();

        try {
            $reqId = (int) $application_id;

            // Get application by ID
            $application = Application::find($reqId);

            if (!$application) {
                return response()->json(['status' => false, 'message' => 'Invalid request sent.']);
            }

            $appPk = $this->applicationPk($application);

            // Use direct DB update to avoid INVISIBLE id column issues with Eloquent save()
            DB::table('applications')
                ->where('id', $appPk)
                ->update([
                    'status' => 'Cancelled',
                    'cancel_reason' => request()->cancel_reason,
                    'updated_at' => now(),
                ]);

            ApplicationStatus::updateOrCreate([
                'application_id' => $appPk,
                'status' => 'Cancelled',
            ]);

            $freelancer_account = User::find($application->user_id);

            $transfer = transfer($freelancer_account->stripe_account_id, $application->total_amount);
            if (!$transfer['status']) {
                return response()->json(['status' => false, 'message' => $transfer['message']]);
            }

            Payment::create([
                'application_id' => $appPk,
                'user_id' => authId(),
                'amount' => -1 * ($application->total_amount * 90 / 100),
                'paymentStatus' => 'succeeded',
                'stripe_transfer_id' => $transfer['stripe_transfer_id'],
            ]);

            Notification::create([
                'user_id' => $application->user_id,
                'title' => 'Project completion cancelled',
                'message' => 'Project completion has been cancelled.',
                'type' => 'cancelled',
                'link' => '/dashboard?tab=ongoing',
                'reference_id' => $application->project_id,
            ]);

            $proj = Project::find($application->project_id);

            if ($proj) {
                Notification::create([
                    'user_id' => $proj->user_id,
                    'title' => 'Project completion cancelled',
                    'message' => 'A project completion was cancelled.',
                    'type' => 'cancelled',
                    'link' => '/dashboard?tab=ongoing',
                    'reference_id' => $proj->id,
                ]);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Project cancelled successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
