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

        // Bridge fix: ensure projects.id is always set to my_row_id (so legacy joins work)
        if (empty($data->id) || (string) $data->id === '0') {
            DB::table('projects')
                ->where('my_row_id', $data->my_row_id)
                ->update(['id' => $data->my_row_id]);

            $data->id = $data->my_row_id;
        }

        return ['status' => true];
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getApprovedFreelancerIdAttribute()
    {
        $application = Application::where('project_id', $this->id)
            ->where('status', 'Approved')
            ->first();

        return $application ? $application->user_id : null;
    }

    public function datatable()
    {
        $data = DB::table('projects')
            ->join('users', 'users.id', 'projects.user_id')
            ->join('categories', 'categories.id', 'projects.category_id')
            ->leftJoin('applications', 'applications.project_id', 'projects.id')
            ->groupBy('projects.id')
            ->select(
                'projects.*',
                'categories.name as category',
                'users.first_name as client',
                DB::raw('COUNT(applications.id) as application')
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
                $attachments = DB::table('application_attachments')->where('application_id', $data->id)->get();
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
