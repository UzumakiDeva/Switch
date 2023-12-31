<?php

use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('features')->insert(
        [
            'heading' => '2FA SECURITY',
            'desc' => 'We operate the advanced blockchain exchange platform, which is designed for users who demand secure exchange execution.',
            'image' => '2fa-security.svg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

          DB::table('features')->insert(
        [
            'heading' => 'EASY TO USE',
            'desc' => 'We make getting into your assets easy with simple tools. Choose the cryptocurrency you would like to exchange, and then input your receiving address and amount.',
            'image' => 'easy-security.svg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);


            DB::table('features')->insert(
        [
            'heading' => 'SECURE WALLET',
            'desc' => 'Security will always be a top priority in every decision we make, and we provides a safe, reliable and stable environment for digital assets exchange by advanced technologies.',
            'image' => 'secure-wallet-y.svg',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
    }
}
