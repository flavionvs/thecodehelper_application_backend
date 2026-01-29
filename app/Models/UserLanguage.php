<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    use HasFactory;

    /**
     * NOTE: Table has INVISIBLE id as DB primary key.
     */
    protected $guarded = [];
}
