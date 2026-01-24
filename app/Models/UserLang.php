<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLang extends Model
{
    use HasFactory;

    /**
     * NOTE: Table has INVISIBLE my_row_id as DB primary key.
     * Using 'id' for compatibility with existing code.
     */
    protected $guarded = [];

    public function lang(){
        return $this->belongsTo(Lang::class);
    }
}
