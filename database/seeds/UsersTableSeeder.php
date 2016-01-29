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
        $country    = DB::table('countries')->where('iso_3166_2', '=', 'ID')
            // ->get(['calling_code', 'id'])
            ->first();
        $administrator      = DB::table('users')->where('name', '=', 'administrator');
        if(!$administrator->exists()){
            DB::table('users')->insert([
                'name' => 'administrator',
                'email' => 'admin@jetcompany.co',
                'password' => bcrypt('secret'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
                'phone_number' => '62000000000',
                'status' => TRUE,
                'channel' => hash('crc32b', bcrypt(uniqid('62000000000'))),
                'verification_code' => '******',
                'country_id' => $country->id,
                'gender' => 'male',
                'firstname' => 'Administrator',
                'lastname' => '-',
            ]);
        }else{
            $administrator->update([
                'phone_number' => '62000000000',
                'status' => TRUE,
                'channel' => hash('crc32b', bcrypt(uniqid('62000000000'))),
                'verification_code' => '******',
                'country_id' => $country->id,
                'gender' => 'male',
                'firstname' => 'Administrator',
                'lastname' => '-',
            ]);
        }

        $operator       = DB::table('users')->where('name', '=', 'operator');
        if(!$operator->exists()){
            DB::table('users')->insert([
                'name' => 'operator',
                'email' => 'operator@jetcompany.co',
                'password' => bcrypt('secret'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
                'phone_number' => '6211111111111',
                'status' => TRUE,
                'channel' => hash('crc32b', bcrypt(uniqid('6211111111111'))),
                'verification_code' => '******',
                'country_id' => $country->id,
                'gender' => 'male',
                'firstname' => 'Operator',
                'lastname' => '-',
            ]);
        }else{
            $operator->update([
                'phone_number' => '6211111111111',
                'status' => TRUE,
                'channel' => hash('crc32b', bcrypt(uniqid('6211111111111'))),
                'verification_code' => '******',
                'country_id' => $country->id,
                'gender' => 'male',
                'firstname' => 'Operator',
                'lastname' => '-',
            ]);
        }

        $root           = DB::table('users')->where('name', '=', 'root');
        if(!$root->exists()){
            DB::table('users')->insert([
                'name' => 'root',
                'email' => 'root@jetcompany.co',
                'password' => bcrypt('secret'),
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
                'phone_number' => '6233333333333',
                'status' => TRUE,
                'channel' => hash('crc32b', bcrypt(uniqid('6233333333333'))),
                'verification_code' => '******',
                'country_id' => $country->id,
                'gender' => 'male',
                'firstname' => 'Root',
                'lastname' => '-',
            ]);
        }else{
            $root->update([
                'phone_number' => '6233333333333',
                'status' => TRUE,
                'channel' => hash('crc32b', bcrypt(uniqid('6233333333333'))),
                'verification_code' => '******',
                'country_id' => $country->id,
                'gender' => 'male',
                'firstname' => 'Root',
                'lastname' => '-',
            ]);
        }
    }
}
