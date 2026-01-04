<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * IMPORTANT:
     * In the DB, applications PRIMARY KEY is `my_row_id` (AUTO_INCREMENT),
     * NOT `id`. If we don't set this, Eloquent will treat `id` as the PK,
     * which causes $application->id to be 0/null and breaks payment linking.
     */
    protected $table = 'applications';
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * application_attachments.application_id stores the STABLE application PK (applications.my_row_id)
     */
    public function attachments()
    {
        return $this->hasMany(ApplicationAttachment::class, 'application_id', 'my_row_id');
    }
}
