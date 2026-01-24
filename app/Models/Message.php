<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * Boot method to add global scope.
     * IMPORTANT: my_row_id is INVISIBLE in MySQL, so it won't appear in SELECT *
     * We select *, my_row_id to include both all columns AND the invisible primary key.
     */
    protected static function booted()
    {
        static::addGlobalScope('select_my_row_id', function (Builder $builder) {
            $builder->selectRaw('messages.*, messages.my_row_id');
        });
    }
}
