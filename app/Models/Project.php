<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use yajra\Datatables\DataTables;
use DB;

class Project extends Model
{
    use HasFactory;

    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT).
     * Eloquent must use that as the primary key.
     */
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    /**
     * Keep this if your frontend/admin expects `approved_freelancer_id`
     * as a computed attribute.
     */
    protected $appends = ['approved_freelancer_id'];

    public function insertUpdate($request, $id = null)
    {
        $req = request()->except('_token', '_method');

        if (!empty($id)) {
            // $id is the business id (projects.id) used in URLs/joins
            $q = Project::withoutGlobalScope(new ActiveScope)->where('id', $id);

            if (!$q->exists()) {
                return ['status' => false, 'message' => 'Project not found'];
            }

            $q->update($req);

            return ['status' => true];
        }

        // CREATE
        $req['status'] = 'pending';
        $req['payment_status'] = 'unpaid';
        $req['selected_application_id'] = null;

        $data = Project::create($req);

        // ALWAYS bridge: keep legacy joins stable (applications.project_id -> projects.id)
        DB::table('projects')
            ->where('my_row_id', $data->my_row_id)
            ->update(['id' => $data->my_row_id]);

        // Ensure in-memory model also reflects the legacy business id
        $data->id = $data->my_row_id;

        return ['status' => true];
    }

    /**
     * Get applications for this project.
     * 
     * IMPORTANT: applications.project_id may reference either projects.id or projects.my_row_id
     * Since projects.id is 0 for newer records but my_row_id is always valid,
     * we use a custom query that matches both.
     */
    public function application()
    {
        // Use my_row_id as the foreign key since it's always the real primary key
        return $this->hasMany(Application::class, 'project_id', 'my_row_id');
    }

    /**
     * Alternative method to get application count that handles the id/my_row_id issue
     */
    public function getApplicationCountAttribute()
    {
        return Application::where('project_id', $this->my_row_id)
            ->orWhere('project_id', $this->id)
            ->count();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * IMPORTANT:
     * Applications primary key is now `my_row_id` (see Application model fix).
     * Also note: application.status values appear to be "Approved" with capital A.
     * Check both id and my_row_id since applications.project_id may reference either.
     */
    public function getApprovedFreelancerIdAttribute()
    {
        $application = Application::where(function($q) {
                $q->where('project_id', $this->my_row_id)
                  ->orWhere('project_id', $this->id);
            })
            ->where('status', 'Approved')
            ->first();

        return $application ? $application->user_id : null;
    }

    public function datatable()
    {
        $data = DB::table('projects')
            ->join('users', 'users.id', 'projects.user_id')
            ->join('categories', 'categories.id', 'projects.category_id')
            ->leftJoin('applications', function($join) {
                // Match applications.project_id to either projects.id or projects.my_row_id
                $join->on('applications.project_id', '=', 'projects.my_row_id')
                     ->orOn('applications.project_id', '=', 'projects.id');
            })
            ->groupBy('projects.my_row_id')
            ->select(
                'projects.*',
                DB::raw('projects.my_row_id as id'),  // Use my_row_id as the display id
                'categories.name as category',
                'users.first_name as client',
                // applications.my_row_id is the real PK; using COUNT(applications.id) can return 0
                DB::raw('COUNT(applications.my_row_id) as application')
            );

        if (request()->category) {
            $data->where('category_id', request()->category);
        }

        if (request()->client) {
            $data->where('projects.user_id', request()->client);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', '{{dateFormat($created_at)}}')
            ->addColumn('category_id', '{{$category}}')
            ->addColumn('client_id', '{{$client}}')
            ->addColumn('application', function ($data) {
                return $data->application > 0
                    ? '<a href="' . url(guardName() . '/application', $data->id) . '">' . $data->application . '</a>'
                    : $data->application;
            })
            ->addColumn('action', function ($data) {
                $action = [];

                if (request()->user()->can('edit project')) {
                    $action[] = [
                        'name' => 'edit',
                        'modal' => 'large',
                        'url' => route(guardName() . ".project.edit", $data->id),
                        'header' => 'Edit project'
                    ];
                }

                if (request()->user()->can('delete project')) {
                    $action[] = [
                        'name' => 'delete',
                        'url' => route(guardName() . '.project.destroy', [$data->id]),
                        'modalId' => 'delete-modal',
                        'header' => 'Delete'
                    ];
                }

                return view('admin.layout.action', compact('action'));
            })
            ->rawColumns(['action', 'application'])
            ->make(true);
    }

    public function applicationDatatable($project_id)
    {
        $data = DB::table('applications')
            ->join('users', 'users.id', 'applications.user_id')
            ->join('projects', 'projects.id', 'applications.project_id')
            ->select(
                'applications.*',
                'users.first_name as username',
                'projects.title as project',
            );

        if (request()->user) {
            $data->where('applications.user_id', request()->user);
        }

        if ($project_id) {
            $data->where('applications.project_id', $project_id);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', '{{dateFormat($created_at)}}')
            ->editColumn('user_id', '{{$username}}')
            ->editColumn('project_id', '{{$project}}')
            ->editColumn('attachment', function ($data) {
                /**
                 * IMPORTANT:
                 * application_attachments.application_id should reference applications.my_row_id.
                 * Since the datatable query selects "applications.*", we have $data->my_row_id available.
                 */
                $applicationPk = $data->my_row_id ?? $data->id ?? null;

                $attachments = $applicationPk
                    ? DB::table('application_attachments')->where('application_id', $applicationPk)->get()
                    : collect();

                $links = '';

                if ($attachments->count() > 0) {
                    foreach ($attachments as $item) {
                        $links .= '<a href="' . asset($item->attachment) . '">View Attachment</a><br>';
                    }
                }

                return $links ?: 'N/A';
            })
            ->rawColumns(['application', 'links', 'attachment'])
            ->make(true);
    }
}
