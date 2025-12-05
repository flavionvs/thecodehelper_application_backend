<?php
 
namespace App\Scopes;
 
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
 
class DatatableScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)    
    {        
        // if(myRoleId() != 1){
        $isOrdered = request()->input();
        if(isset($isOrdered['order'][0]['column']) && $isOrdered['order'][0]['column'] == 0 && $isOrdered['order'][0]['dir'] == 'asc'){
            if(request()->url() == url(guardName().'/kyc')){
                $builder->orderByDESC('updated_at');
            }elseif($model->getTable() == 'bookings'){
                $builder->orderBy('date', 'desc')->orderBy('from_time', 'desc');
            }else{
                $builder->orderByDESC('created_at');
            }
        }          
    }
}