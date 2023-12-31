<?php

use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('general_settings')->insert(
        [
            'title'         => 'Site Title',
            'lang'          => 'en',
            'key'           => 'site_title',
            'description'   => 'Panther Exchange',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Site Description',
            'lang'          => 'en',
            'key'           => 'site_discription',
            'description'   => 'Buy, sell and trade Bitcoin (BTC), Ethereum (ETH),Litecoin (LTC),Ripple (XRP) & Tether (USDT)',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Logo',
            'lang'          => 'en',
            'key'           => 'logo',
            'description'   => 'logo.png',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);
        DB::table('general_settings')->insert(
        [
            'title'         => 'Favicon',
            'lang'          => 'en',
            'key'           => 'favicon',
            'description'   => 'favicon.png',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Admin Email',
            'lang'          => 'en',
            'key'           => 'email',
            'description'   => 'support@Matrix.com',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'OS Version',
            'lang'          => 'en',
            'key'           => 'osversion',
            'description'   => '1.0',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Twofa OTP Mandatory Withdraw',
            'lang'          => 'en',
            'key'           => 'twofa_withdraw_enable',
            'description'   => '',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'KYC Mandatory for Registartion',
            'lang'          => 'en',
            'key'           => 'kyc_enable',
            'description'   => '',
            'status'        => 0,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Privacy Policy',
            'lang'          => 'en',
            'key'           => 'privacy-policy',
            'description'   => '<h3 class="t-darkblue fnt-bld mt-10">Changes to this privacy policy</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Website Security</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Communications</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Terms & Conditions',
            'lang'          => 'en',
            'key'           => 'terms-conditions',
            'description'   => '<h3 class="t-darkblue fnt-bld mt-10">Changes to this privacy policy</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Website Security</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Communications</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'About',
            'lang'          => 'en',
            'key'           => 'aboutus',
            'description'   => ' <p class="content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Best and Secure Trading',
            'lang'          => 'en',
            'key'           => 'banner',
            'description'   => 'Cryptocurrency Exchange Platform',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => '2FA Security',
            'lang'          => 'en',
            'key'           => 'features',
            'description'   => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
            'image'         => '2fa-security.svg',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Easy Trade',
            'lang'          => 'en',
            'key'           => 'features',
            'description'   => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
            'image'         => 'easy-security.svg',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Secure Wallet',
            'lang'          => 'en',
            'key'           => 'features',
            'description'   => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
            'image'         => 'secure-wallet-y.svg',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'How it works',
            'lang'          => 'en',
            'key'           => 'how_it_work_heading',
            'description'   => "Our platform longest running and most liquid bitcoin and cryptocurrency exchange. Our platform longest running coin and crypy exchange. Our platform longest running ayptocurrency exchange.",
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Create account',
            'lang'          => 'en',
            'key'           => 'how_it_work',
            'description'   => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Update KYC',
            'lang'          => 'en',
            'key'           => 'how_it_work',
            'description'   => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Start Trade',
            'lang'          => 'en',
            'key'           => 'how_it_work',
            'description'   => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'KYC Terms & Conditions',
            'lang'          => 'en',
            'key'           => 'kyc_content',
            'description'   => '<h3 class="t-darkblue fnt-bld mt-10">Changes to this privacy policy</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Website Security</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Communications</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'IEO Rules Book', 
            'lang'          => 'en',
            'key'           => 'ieorule',
            'description'   => '<h3 class="t-darkblue fnt-bld mt-10">Changes to this privacy policy</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Website Security</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Communications</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Terms & Services', 
            'lang'          => 'en',
            'key'           => 'termsservice',
            'description'   => '<h3 class="t-darkblue fnt-bld mt-10">Changes to this privacy policy</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Website Security</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Communications</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

        DB::table('general_settings')->insert(
        [
            'title'         => 'Anti Money Laundering', 
            'lang'          => 'en',
            'key'           => 'aml',
            'description'   => '<h3 class="t-darkblue fnt-bld mt-10">Changes to this privacy policy</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Website Security</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p><h3 class="t-darkblue fnt-bld">Communications</h3><p class="content t-black">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages</p>',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);
        DB::table('general_settings')->insert(
        [
            'title'         => 'Deposit enable disable', 
            'lang'          => 'en',
            'key'           => 'deposit_enable_disable',
            'description'   => 'Deposit enable disable',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);
         DB::table('general_settings')->insert(
        [
            'title'         => 'withdraw enable disable', 
            'lang'          => 'en',
            'key'           => 'withdraw_enable_disable',
            'description'   => 'withdraw enable disable',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);

         DB::table('general_settings')->insert(
        [
            'title'         => 'Bittreax apikey', 
            'lang'          => 'en',
            'key'           => 'Bittreax_apikey',
            'description'   => 'Bittreax apikey',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);


         DB::table('general_settings')->insert(
        [
            'title'         => 'Bittrex Secret', 
            'lang'          => 'en',
            'key'           => 'Bittreax_secret',
            'description'   => 'Bittrex Secret',
            'status'        => 1,
            'created_at'    => date("Y-m-d H:i:s"),
            'updated_at'    => date("Y-m-d H:i:s"),     
        ]);
    }
}
