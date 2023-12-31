<?php

use Illuminate\Database\Seeder;

class HowitworksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
      DB::table('how_it_works')->insert(
      [
		      'title' => 'CREATE ACCOUNT',
          'desc' => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
          'created_at' => date("Y-m-d H:i:s"),
           'updated_at' => date("Y-m-d H:i:s"),     
      ]);


       DB::table('how_it_works')->insert(
      [
          'title' => 'UPDATE KYC',
          'desc' => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
          'created_at' => date("Y-m-d H:i:s"),
           'updated_at' => date("Y-m-d H:i:s"),     
      ]);


        DB::table('how_it_works')->insert(
      [
          'title' => 'START TRADE',
          'desc' => "Create a new account here if you dont have one or login here with your username and password if you are a registered user.",
          'created_at' => date("Y-m-d H:i:s"),
           'updated_at' => date("Y-m-d H:i:s"),     
      ]);
        
    }
}