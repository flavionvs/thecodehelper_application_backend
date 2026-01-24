<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * NOTE: Table has INVISIBLE my_row_id, but 'id' is used in foreign keys.
     */
}
