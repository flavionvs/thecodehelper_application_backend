<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array =[
            'view user',
            'create user',
            'edit user',
            'delete user',            
        ];
        // admin is a guard
        // if more guard are there like teacher, employee etc
        // copy and paste the loop
        
        foreach($array as $item){
            Permission::firstOrCreate(['name' => $item, 'guard_name' => 'admin']);
        }
        // foreach($array as $item){
        //     Permission::firstOrCreate(['name' => $item, 'guard_name' => 'employee']);
        // }        
    }
}
