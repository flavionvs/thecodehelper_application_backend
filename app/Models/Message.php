<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT, INVISIBLE).
     * Must set this or Eloquent will use 'id' which causes issues.
     */
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];
}
