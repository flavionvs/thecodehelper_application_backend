<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Console\Tester\ApplicationTester;

class Application extends Model
{
    use HasFactory, SoftDeletes; 
    
    protected $guarded = [];
    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function attachments(){
        return $this->hasMany(ApplicationAttachment::class);
    }
}
