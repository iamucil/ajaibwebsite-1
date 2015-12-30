<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'administrator',
            'email' => 'admin@jetcompany.co',
            'password' => bcrypt('secret'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
            'phone_number' => '+62000000000',
            'status' => TRUE,
            'channel' => '62000000000',
            'verification_code' => '000000',
        ], [
            'name' => 'operator',
            'email' => 'operator@jetcompany.co',
            'password' => bcrypt('secret'),
            'created_at' => DB::raw('NOW()'),
            'updated_at' => DB::raw('NOW()'),
            'phone_number' => '+6211111111111',
            'status' => TRUE,
            'channel' => '6211111111111',
            'verification_code' => '111111',
        ]]);
    }
}
