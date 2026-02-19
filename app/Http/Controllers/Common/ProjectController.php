<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{    
    protected $model;
    public function __construct(){
        $this->model = new Project;
        $this->middleware('permission:view project',   ['only' => ['show', 'index']]);
        $this->middleware('permission:create project', ['only' => ['create','store']]);
        $this->middleware('permission:edit project', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete project',   ['only' => ['destroy']]);             
        
    }
    public function index(Request $request){        
        if($request->ajax()){                    
            return $this->model->datatable();
        }        
        $data['categories'] = Category::get();     
        $data['clients'] = User::where('role','Client')->get();     
       return view('common.project.index', $data);
    }
    public function application(Request $request, $project_id = null){        
        if($request->ajax()){                    
            return $this->model->applicationDatatable($project_id);
        }            
        $users = Application::groupBy('user_id')->get();    
        $projects = Application::groupBy('project_id')->get();    
       return view('common.project.application', compact('users','projects'));
    }

    public function create(){
        $data = new Project;
        $category = Category::get();     
        $clients = User::where('role','Client')->get();     
        return view('common.project.form', compact('data','category','clients'));
    }

    public function store(ProjectRequest $request){   
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request);   
            if($query['status']){
                DB::commit();  
                return response()->json(['status'=>true,'message'=> 'Project created successfully']);
            }else{
                return response()->json(['status'=>false,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }        
    }
    
    public function edit($id){
        $data = Project::find($id);
        $category = Category::get();     
        $clients = User::where('role','Client')->get();     
        return view('common.project.form', compact('data','category','clients'));    
    }

    public function update(ProjectRequest $request, $id){ 
        DB::BeginTransaction();
        try{   
            $query = $this->model->insertUpdate($request, $id);                  
            if($query['status']){
                DB::commit();
                return response()->json(['status'=>true,'message'=> 'Project updated successfully']);
            }else{
                return response()->json(['status'=>false,'message'=> $query['message']]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }    
    }

    public function destroy($id){
        DB::BeginTransaction();
        try{        
            $delete = Project::find($id)->delete();
            DB::commit();
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=> showError($e)]);
        }
        return response()->json(['status'=>true,'message'=> 'Project deleted successfully!']);
    }

    /**
     * Show cancellation requests page
     */
    public function cancellationRequests(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('projects')
                ->join('users as clients', 'clients.id', '=', 'projects.user_id')
                ->join('applications', function ($join) {
                    $join->on('applications.project_id', '=', 'projects.id')
                        ->where(function ($q) {
                            $q->where('applications.status', 'Approved')
                              ->orWhere('applications.status', 'Completion Requested');
                        });
                })
                ->join('users as freelancers', 'freelancers.id', '=', 'applications.user_id')
                ->whereIn('projects.status', ['cancellation_requested', 'cancelled'])
                ->select(
                    'projects.id',
                    'projects.title',
                    'projects.status as project_status',
                    'projects.budget',
                    'projects.updated_at',
                    'clients.first_name as client_name',
                    'clients.email as client_email',
                    'freelancers.first_name as freelancer_name',
                    'freelancers.email as freelancer_email',
                    'applications.cancel_reason',
                    'applications.amount',
                    'applications.total_amount',
                    'applications.id as application_id'
                )
                ->orderByDesc('projects.updated_at');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('project', function ($row) {
                    return $row->title . ' (#' . $row->id . ')';
                })
                ->addColumn('client', function ($row) {
                    return $row->client_name . '<br><small>' . $row->client_email . '</small>';
                })
                ->addColumn('freelancer', function ($row) {
                    return $row->freelancer_name . '<br><small>' . $row->freelancer_email . '</small>';
                })
                ->addColumn('amount', function ($row) {
                    return '$' . number_format($row->amount ?? $row->budget, 2);
                })
                ->addColumn('cancel_reason', function ($row) {
                    $reason = $row->cancel_reason ?? 'No reason provided';
                    return strlen($reason) > 50 ? substr($reason, 0, 50) . '...' : $reason;
                })
                ->addColumn('requested_at', function ($row) {
                    return dateFormat($row->updated_at);
                })
                ->addColumn('status', function ($row) {
                    if ($row->project_status === 'cancellation_requested') {
                        return '<span class="badge badge-warning">Pending Review</span>';
                    }
                    return '<span class="badge badge-danger">Cancelled</span>';
                })
                ->addColumn('action', function ($row) {
                    if ($row->project_status === 'cancellation_requested') {
                        return '<button class="btn btn-sm btn-danger refund-btn" 
                                    data-project-id="' . $row->id . '" 
                                    data-project-name="' . htmlspecialchars($row->title) . '"
                                    data-amount="' . number_format($row->amount ?? $row->budget, 2) . '">
                                    Refund & Cancel
                                </button>
                                <button class="btn btn-sm btn-secondary reject-btn mt-1" 
                                    data-project-id="' . $row->id . '" 
                                    data-project-name="' . htmlspecialchars($row->title) . '">
                                    Reject
                                </button>';
                    }
                    return '<span class="text-muted">Processed</span>';
                })
                ->rawColumns(['client', 'freelancer', 'status', 'action'])
                ->make(true);
        }

        return view('common.project.cancellation-requests');
    }

    /**
     * Process cancellation: approve (refund & cancel) or reject
     */
    public function processCancellation(Request $request, $project_id)
    {
        DB::beginTransaction();

        try {
            $project = Project::find($project_id);

            if (!$project || $project->status !== 'cancellation_requested') {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Project not found or not in cancellation_requested status.']);
            }

            $application = Application::where('project_id', $project->id)
                ->where(function ($q) {
                    $q->where('status', 'Approved')
                      ->orWhere('status', 'Completion Requested');
                })
                ->first();

            if (!$application) {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'No approved application found for this project.']);
            }

            $action = $request->input('action'); // 'approve' or 'reject'

            if ($action === 'approve') {
                // ✅ Transfer freelancer's earned amount
                $freelancer = User::find($application->user_id);

                if ($freelancer && $freelancer->stripe_account_id && $application->amount > 0) {
                    $transfer = transfer($freelancer->stripe_account_id, $application->amount);
                    if (!$transfer['status']) {
                        DB::rollBack();
                        return response()->json(['status' => false, 'message' => 'Stripe transfer failed: ' . $transfer['message']]);
                    }

                    // Record payment to freelancer
                    Payment::create([
                        'application_id' => $application->id,
                        'user_id' => $application->user_id,
                        'amount' => $application->amount,
                        'paymentStatus' => 'succeeded',
                        'stripe_transfer_id' => $transfer['stripe_transfer_id'],
                    ]);

                    // Record debit from client
                    Payment::create([
                        'application_id' => $application->id,
                        'user_id' => $project->user_id,
                        'amount' => -1 * ($application->total_amount ?? $application->amount),
                        'paymentStatus' => 'succeeded',
                    ]);
                }

                // Update application status
                $application->status = 'Cancelled';
                $application->save();

                ApplicationStatus::updateOrCreate([
                    'application_id' => $application->id,
                    'status' => 'Cancelled',
                ]);

                // Update project status
                DB::table('projects')
                    ->where('id', $project->id)
                    ->update([
                        'status' => 'cancelled',
                        'payment_status' => 'refunded',
                        'updated_at' => now(),
                    ]);

                // Notify freelancer
                Notification::create([
                    'user_id' => $application->user_id,
                    'title' => 'Project Cancelled ❌',
                    'message' => "The project \"{$project->title}\" has been cancelled and the refund has been processed. Your payment has been transferred.",
                    'type' => 'cancelled',
                    'link' => '/user/project?type=cancelled',
                    'reference_id' => $project->id,
                ]);

                // Notify client
                Notification::create([
                    'user_id' => $project->user_id,
                    'title' => 'Cancellation Approved ✅',
                    'message' => "Your cancellation request for \"{$project->title}\" has been approved and the refund has been processed.",
                    'type' => 'cancelled',
                    'link' => '/user/project?type=cancelled',
                    'reference_id' => $project->id,
                ]);

                DB::commit();
                return response()->json(['status' => true, 'message' => 'Project cancelled and refund processed successfully.']);

            } elseif ($action === 'reject') {
                // ✅ Reject: restore to in_progress
                DB::table('projects')
                    ->where('id', $project->id)
                    ->update([
                        'status' => 'in_progress',
                        'updated_at' => now(),
                    ]);

                $rejectReason = $request->input('admin_notes', 'Your cancellation request was not approved.');

                // Notify freelancer
                Notification::create([
                    'user_id' => $application->user_id,
                    'title' => 'Cancellation Rejected ✅',
                    'message' => "The cancellation request for \"{$project->title}\" has been rejected. The project remains in progress.",
                    'type' => 'approved',
                    'link' => '/user/project?type=ongoing',
                    'reference_id' => $project->id,
                ]);

                // Notify client
                Notification::create([
                    'user_id' => $project->user_id,
                    'title' => 'Cancellation Request Rejected',
                    'message' => "Your cancellation request for \"{$project->title}\" has been rejected. Reason: {$rejectReason}. The project remains in progress.",
                    'type' => 'cancelled',
                    'link' => '/user/project?type=ongoing',
                    'reference_id' => $project->id,
                ]);

                DB::commit();
                return response()->json(['status' => true, 'message' => 'Cancellation request rejected. Project remains in progress.']);
            }

            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Invalid action.']);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Process cancellation error', ['error' => $e->getMessage(), 'project_id' => $project_id]);
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
