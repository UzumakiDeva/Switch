<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //$this->call(CountriesTableSeeder::class);
        $this->call([
            CountriesTableSeeder::class,
            TradepairsTableSeeder::class,
            CommissionsTableSeeder::class,
            CMSTableSeeder::class,
            GeneralSettingsTableSeeder::class,
            AdminTableSeeder::class,
            AdminbankdetailsTableSeeder::class

        ]);
        
    }
}
