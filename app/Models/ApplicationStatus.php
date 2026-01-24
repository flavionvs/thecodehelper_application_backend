<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    /**
     * NOTE: Table has INVISIBLE my_row_id as DB primary key.
     */
    protected $guarded = [];
}
