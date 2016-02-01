<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table      = \Config::get('entrust.roles_table');

        if(\Schema::hasTable($table)){
            $root   = DB::table($table)->where('name', '=', 'root');
            if(!$root->exists()){
                DB::table($table)->insert([
                    'name' => 'root',
                    'display_name' => 'Super User',
                    'description' => 'User is allowed to do everything',
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }else{
                $root->update([
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }

            $administrator      = DB::table($table)->where('name', '=', 'admin');
            if(!$administrator->exists()){
                DB::table($table)->insert([
                    'name' => 'admin',
                    'display_name' => 'User Administrator',
                    'description' => 'user is allowed to manage and edit other users data',
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }else{
                $administrator->update([
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }

            $operator           = DB::table($table)->where('name', '=', 'operator');
            if(!$operator->exists()){
                DB::table($table)->insert([
                    'name' => 'operator',
                    'display_name' => 'Operator',
                    'description' => 'User Is Only Allowed To Manage And Edit Their Data',
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }else{
                $operator->update([
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }

            $users              = DB::table($table)->where('name', '=', 'users');
            if(!$users->exists()){
                DB::table($table)->insert([
                    'name' => 'users',
                    'display_name' => 'End User',
                    'description' => 'User is only allowed to manage and edit their data',
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }else{
                $users->update([
                    'created_at' => DB::raw('NOW()'),
                    'updated_at' => DB::raw('NOW()'),
                ]);
            }
        }
    }
}
