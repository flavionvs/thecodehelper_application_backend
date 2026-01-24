<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class BasicSetting extends Model
{
    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT, INVISIBLE).
     */
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';
}
