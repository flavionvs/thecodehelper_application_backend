<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Payment extends Model
{
    use HasFactory;

    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT).
     */
    protected $table = 'payments';
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    protected static function booted()
    {
        /**
         * IMPORTANT: my_row_id is INVISIBLE in MySQL, so it won't appear in SELECT *
         * We need to explicitly select it for relationships and operations to work.
         */
        static::addGlobalScope('select_my_row_id', function (Builder $builder) {
            $builder->addSelect('payments.my_row_id');
        });

        /**
         * Keep legacy/business id column in sync.
         * Some older parts of the app still read payments.id (not PK).
         */
        static::created(function (Payment $p) {
            if (empty($p->id) || (int) $p->id === 0) {
                DB::table('payments')
                    ->where('my_row_id', $p->my_row_id)
                    ->update(['id' => $p->my_row_id]);

                // keep in-memory model consistent
                $p->id = $p->my_row_id;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function datatable()
    {
        $data = DB::table('payments')
            ->join('users', 'users.id', 'payments.user_id')
            ->select(
                'payments.*',
                'users.first_name as username',
            );

        if (request()->client) {
            $data->where('payments.user_id', request()->client);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', '{{dateFormat($created_at)}}')
            ->addColumn('user_id', '{{$username}}')
            ->rawColumns(['action', 'application'])
            ->make(true);
    }
}
