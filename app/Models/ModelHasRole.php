<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class ModelHasRole extends Model
{
    use HasFactory;

    /**
     * NOTE: Table has INVISIBLE id as DB primary key.
     */
    
    public function role(){
        return $this->belongsTo(Role::Class);
    }
}
