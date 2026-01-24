<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT, INVISIBLE).
     */
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    /**
     * Boot method - sync id with my_row_id on create.
     */
    protected static function booted()
    {
        static::created(function ($model) {
            if (empty($model->id) || (int)$model->id === 0) {
                \DB::table('messages')
                    ->where('my_row_id', $model->my_row_id)
                    ->update(['id' => $model->my_row_id]);
                $model->id = $model->my_row_id;
            }
        });
    }
}
