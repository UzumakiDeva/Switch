<?php

use Illuminate\Database\Seeder;

class SocialMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('social_media')->insert(
        [
            'pinterest' => 'https://www.pinterest.com/Orderbook/',
            'fb' => 'https://www.instagram.com/Orderbook/',
            'twitter' => 'https://twitter.com/Orderbook',
            'instagram' => 'https://twitter.com/Orderbook',
            'telegram' => 'https://www.instagram.com/Orderbook',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
    }
}
