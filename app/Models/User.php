<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class User extends Authenticatable implements JWTSubject
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Production DB primary key is my_row_id (AUTO_INCREMENT, INVISIBLE).
     * Must set this or Eloquent will use 'id' which causes issues.
     */
    protected $primaryKey = 'my_row_id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function insertUpdate($request, $id = null){        
        $req = request()->except('_token','_method','lang_id','programming_language_id');
        $req['password'] = Hash::make($request->password);                   
        if($id){
            $user = User::where('id',$id);                        
            $user->update($req);
            $user = $user->first();
        }else{
            $user = User::create($req);            
        }        
        
        if (is_array(request()->lang_id)) {  // [1,2,3]
          UserLang::where('user_id', $user->id)
              ->whereNotIn('lang_id', request()->lang_id)
              ->delete();  
          
          foreach (request()->lang_id as $item) {
              UserLang::updateOrCreate(
                  ['user_id' => $user->id, 'lang_id' => $item],  // Search condition
                  ['user_id' => $user->id, 'lang_id' => $item]   // Data to insert/update
              );
          }
        } else {
            UserLang::where('user_id', $user->id)->delete();
        }
        if (is_array(request()->technology_id)) {  // [1,2,3]
          UserTechnology::where('user_id', $user->id)
              ->whereNotIn('technology_id', request()->technology_id)
              ->delete();  
          
          foreach (request()->technology_id as $item) {
              UserTechnology::updateOrCreate(
                  ['user_id' => $user->id, 'technology_id' => $item],  // Search condition
                  ['user_id' => $user->id, 'technology_id' => $item]   // Data to insert/update
              );
          }
        } else {
            UserTechnology::where('user_id', $user->id)->delete();
        }
        if (is_array(request()->programming_language_id)) {  // [1,2,3]
          UserProgrammingLanguage::where('user_id', $user->id)
              ->whereNotIn('programming_language_id', request()->programming_language_id)
              ->delete();  
          
          foreach (request()->programming_language_id as $item) {
              UserProgrammingLanguage::updateOrCreate(
                  ['user_id' => $user->id, 'programming_language_id' => $item],  // Search condition
                  ['user_id' => $user->id, 'programming_language_id' => $item]   // Data to insert/update
              );
          }
        } else {
            UserProgrammingLanguage::where('user_id', $user->id)->delete();
        }
        if (is_array(request()->language)) {  // [1,2,3]
          UserLanguage::where('user_id', $user->id)
              ->whereNotIn('language', request()->language)
              ->delete();  
          
          foreach (request()->language as $item) {
              UserLanguage::updateOrCreate(
                  ['user_id' => $user->id, 'language' => $item],  // Search condition
                  ['user_id' => $user->id, 'language' => $item]   // Data to insert/update
              );
          }
        } else {
            UserLanguage::where('user_id', $user->id)->delete();
        }    
        return true;
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    function myRole(){
        return $this->hasOne(ModelHasRole::class,'model_id', 'id');
    }
    // public function scopeAdminUser($query){
    //     return $query->where(function($q){
    //         $q->where('role','=', 'Admin');
    //     });
    // }
    function scopeGetUser($query){
       return $query->where('role', 'User');
    }
    function userTechnology(){
        return $this->hasMany(UserTechnology::class);
    }
    function userLang(){
        return $this->hasMany(UserLang::class);
    }
    function userProgrammingLanguage(){
        return $this->hasMany(UserProgrammingLanguage::class);
    }
    function userLanguage(){
        return $this->hasMany(UserLanguage::class);
    }
    public function datatable($role = null){   
        $data = User::where('role', $role)->select('users.*');        
        return DataTables::of($data)
            ->addIndexColumn()         
            ->editColumn('role_id', '{{$role}}')                                   
            ->addColumn('action', function($data){
                $action = [];                      
                if(request()->user()->can('edit user')){
                    $action[] = array('name' => 'edit', 'modal' => 'medium', 'url' => route(guardName().".user.edit", $data->id).'?role='.$data->role, 'class' => 'edit-btn', 'icon' => '<i class="fa fa-edit"></i>', 'header' => 'Edit User');
                }
                if(request()->user()->can('delete user')){
                    $action[] = array('name' => 'delete', 'url' => route(guardName().'.user.destroy', [$data->id]), 'class' => 'delete-btn', 'icon' => '<i class="fa fa-trash"></i>', 'modalId' => 'delete-modal');                     
                }                    
                return view('admin.layout.action', compact('action'));
            })                
            ->rawColumns(['action'])
            ->make(true);
            
    }

}