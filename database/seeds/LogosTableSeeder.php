<?php

use Illuminate\Database\Seeder;

class LogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logos')->insert(
        [
            'logo' => 'logo.png',
            'fav' => 'favicon.png',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
    }
}
