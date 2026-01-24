<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * Boot method to add global scope.
     * IMPORTANT: my_row_id is INVISIBLE in MySQL, so it won't appear in SELECT *
     * We select *, my_row_id to include both all columns AND the invisible primary key.
     */
    protected static function booted()
    {
        static::addGlobalScope('select_my_row_id', function (Builder $builder) {
            $builder->selectRaw('applications.*, applications.my_row_id');
        });
    }

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
