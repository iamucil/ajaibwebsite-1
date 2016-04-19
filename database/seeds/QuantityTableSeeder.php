<?php

use Illuminate\Database\Seeder;

class QuantityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quantities')->delete();
        DB::table('quantities')->insert([[
                'name' => 'Buah',
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ], [
                'name' => 'KG',
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ], [
                'name' => 'Gram',
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ], [
                'name' => 'Meter',
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
            ],
        ]);
    }
}
