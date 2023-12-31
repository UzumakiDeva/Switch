<?php

use Illuminate\Database\Seeder;

class LivepriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('live_price')->insert(
        [
            'coinone' => 'BTC',
            'cointwo' => 'EUR',    
            'price'   => '7278.21',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);
        DB::table('live_price')->insert(
        [
            'coinone' => 'ETH',
            'cointwo' => 'EUR',    
            'price'   => '146.85',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);
        DB::table('live_price')->insert(
        [
            'coinone' => 'XRP',
            'cointwo' => 'EUR',    
            'price'   => '212.19',
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

    }
}
