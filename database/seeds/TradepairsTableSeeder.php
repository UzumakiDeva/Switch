<?php

use Illuminate\Database\Seeder;

class TradepairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tradepairs')->insert(
        [
            'coinone'           => 'BTC',
            'cointwo'           => 'EURO',
            'min_buy_price'     => 1000,
            'min_buy_amount'    => 0.0001,
            'min_sell_price'    => 1000,
            'min_sell_amount'   => 0.0001,
            'open'              => 0,
            'low'               => 0,
            'high'              => 0,
            'close'             => 0,
            'hrchange'          => 0,
            'hrvolume'          => 0,
            'active'            => 1,
            'orderlist'         => 1,
            'type'              => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),     
        ]);
  
        DB::table('tradepairs')->insert(
        [
            'coinone'           => 'ETH',
            'cointwo'           => 'EURO',
            'min_buy_price'     => 90,
            'min_buy_amount'    => 0.0001,
            'min_sell_price'    => 80,
            'min_sell_amount'   => 0.0001,
            'open'              => 0,
            'low'               => 0,
            'high'              => 0,
            'close'             => 0,
            'hrchange'          => 0,
            'hrvolume'          => 0,
            'active'            => 1,
            'orderlist'         => 2,
            'type'              => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),     
        ]);
  
        DB::table('tradepairs')->insert(
        [
            'coinone'           => 'LTC',
            'cointwo'           => 'EURO',
            'min_buy_price'     => 0.001,
            'min_buy_amount'    => 0.0001,
            'min_sell_price'    => 0.001,
            'min_sell_amount'   => 0.0001,
            'open'              => 0,
            'low'               => 0,
            'high'              => 0,
            'close'             => 0,
            'hrchange'          => 0,
            'hrvolume'          => 0,
            'active'            => 1,
            'orderlist'         => 3,
            'type'              => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),     
        ]);    
  
        DB::table('tradepairs')->insert(
          [
              'coinone'           => 'DASH',
              'cointwo'           => 'EURO',
              'min_buy_price'     => 0.001,
              'min_buy_amount'    => 0.0001,
              'min_sell_price'    => 0.001,
              'min_sell_amount'   => 0.0001,
              'open'              => 0,
              'low'               => 0,
              'high'              => 0,
              'close'             => 0,
              'hrchange'          => 0,
              'hrvolume'          => 0,
              'active'            => 1,
              'orderlist'         => 4,
              'type'              => 0,
              'created_at'        => date("Y-m-d H:i:s"),
              'updated_at'        => date("Y-m-d H:i:s"),     
          ]);    
  
        DB::table('tradepairs')->insert(
          [
              'coinone'           => 'USDT',
              'cointwo'           => 'EURO',
              'min_buy_price'     => 0.001,
              'min_buy_amount'    => 0.0001,
              'min_sell_price'    => 0.001,
              'min_sell_amount'   => 0.0001,
              'open'              => 0,
              'low'               => 0,
              'high'              => 0,
              'close'             => 0,
              'hrchange'          => 0,
              'hrvolume'          => 0,
              'active'            => 1,
              'orderlist'         => 5,
              'type'              => 0,
              'created_at'        => date("Y-m-d H:i:s"),
              'updated_at'        => date("Y-m-d H:i:s"),     
          ]); 
        DB::table('tradepairs')->insert(
          [
              'coinone'           => 'XRP',
              'cointwo'           => 'EURO',
              'min_buy_price'     => 0.001,
              'min_buy_amount'    => 0.0001,
              'min_sell_price'    => 0.001,
              'min_sell_amount'   => 0.0001,
              'open'              => 0,
              'low'               => 0,
              'high'              => 0,
              'close'             => 0,
              'hrchange'          => 0,
              'hrvolume'          => 0,
              'active'            => 1,
              'orderlist'         => 6,
              'type'              => 0,
              'created_at'        => date("Y-m-d H:i:s"),
              'updated_at'        => date("Y-m-d H:i:s"),     
          ]);  
            DB::table('tradepairs')->insert(
              [
                  'coinone'           => 'XMR',
                  'cointwo'           => 'EURO',
                  'min_buy_price'     => 0.001,
                  'min_buy_amount'    => 0.0001,
                  'min_sell_price'    => 0.001,
                  'min_sell_amount'   => 0.0001,
                  'open'              => 0,
                  'low'               => 0,
                  'high'              => 0,
                  'close'             => 0,
                  'hrchange'          => 0,
                  'hrvolume'          => 0,
                  'active'            => 1,
                  'orderlist'         => 7,
                  'type'              => 0,
                  'created_at'        => date("Y-m-d H:i:s"),
                  'updated_at'        => date("Y-m-d H:i:s"),     
              ]);
          DB::table('tradepairs')->insert(
            [
                'coinone'           => 'LIO',
                'cointwo'           => 'EURO',
                'min_buy_price'     => 0.001,
                'min_buy_amount'    => 0.0001,
                'min_sell_price'    => 0.001,
                'min_sell_amount'   => 0.0001,
                'open'              => 0,
                  'low'               => 0,
                  'high'              => 0,
                  'close'             => 0,
                  'hrchange'          => 0,
                  'hrvolume'          => 0,
                'active'            => 1,
                'orderlist'         => 8,
                'type'              => 0,
                'created_at'        => date("Y-m-d H:i:s"),
                'updated_at'        => date("Y-m-d H:i:s"),     
            ]);
            DB::table('tradepairs')->insert(
              [
                  'coinone'           => 'NAS',
                  'cointwo'           => 'EURO',
                  'min_buy_price'     => 0.001,
                  'min_buy_amount'    => 0.0001,
                  'min_sell_price'    => 0.001,
                  'min_sell_amount'   => 0.0001,
                  'open'              => 0,
                    'low'               => 0,
                    'high'              => 0,
                    'close'             => 0,
                    'hrchange'          => 0,
                    'hrvolume'          => 0,
                  'active'            => 1,
                  'orderlist'         => 9,
                  'type'              => 0,
                  'created_at'        => date("Y-m-d H:i:s"),
                  'updated_at'        => date("Y-m-d H:i:s"),     
              ]); 
              DB::table('tradepairs')->insert(
                [
                    'coinone'           => 'QBC',
                    'cointwo'           => 'EURO',
                    'min_buy_price'     => 0.001,
                    'min_buy_amount'    => 0.0001,
                    'min_sell_price'    => 0.001,
                    'min_sell_amount'   => 0.0001,
                    'open'              => 0,
                      'low'               => 0,
                      'high'              => 0,
                      'close'             => 0,
                      'hrchange'          => 0,
                      'hrvolume'          => 0,
                    'active'            => 1,
                    'orderlist'         => 10,
                    'type'              => 0,
                    'created_at'        => date("Y-m-d H:i:s"),
                    'updated_at'        => date("Y-m-d H:i:s"),     
                ]);
                DB::table('tradepairs')->insert(
                  [
                      'coinone'           => 'EVX',
                      'cointwo'           => 'EURO',
                      'min_buy_price'     => 0.001,
                      'min_buy_amount'    => 0.0001,
                      'min_sell_price'    => 0.001,
                      'min_sell_amount'   => 0.0001,
                      'open'              => 0,
                        'low'               => 0,
                        'high'              => 0,
                        'close'             => 0,
                        'hrchange'          => 0,
                        'hrvolume'          => 0,
                      'active'            => 1,
                      'orderlist'         => 11,
                      'type'              => 0,
                      'created_at'        => date("Y-m-d H:i:s"),
                      'updated_at'        => date("Y-m-d H:i:s"),     
                  ]);  
                  DB::table('tradepairs')->insert(
                    [
                        'coinone'           => 'BTC',
                        'cointwo'           => 'USDT',
                        'min_buy_price'     => 1000,
                        'min_buy_amount'    => 0.0001,
                        'min_sell_price'    => 1000,
                        'min_sell_amount'   => 0.0001,
                        'open'              => 0,
                        'low'               => 0,
                        'high'              => 0,
                        'close'             => 0,
                        'hrchange'          => 0,
                        'hrvolume'          => 0,
                        'active'            => 1,
                        'orderlist'         => 12,
                        'type'              => 0,
                        'created_at'        => date("Y-m-d H:i:s"),
                        'updated_at'        => date("Y-m-d H:i:s"),     
                    ]);
              
                    DB::table('tradepairs')->insert(
                    [
                        'coinone'           => 'ETH',
                        'cointwo'           => 'USDT',
                        'min_buy_price'     => 90,
                        'min_buy_amount'    => 0.0001,
                        'min_sell_price'    => 80,
                        'min_sell_amount'   => 0.0001,
                        'open'              => 0,
                        'low'               => 0,
                        'high'              => 0,
                        'close'             => 0,
                        'hrchange'          => 0,
                        'hrvolume'          => 0,
                        'active'            => 1,
                        'orderlist'         => 13,
                        'type'              => 0,
                        'created_at'        => date("Y-m-d H:i:s"),
                        'updated_at'        => date("Y-m-d H:i:s"),     
                    ]);
              
                    DB::table('tradepairs')->insert(
                    [
                        'coinone'           => 'LTC',
                        'cointwo'           => 'USDT',
                        'min_buy_price'     => 0.001,
                        'min_buy_amount'    => 0.0001,
                        'min_sell_price'    => 0.001,
                        'min_sell_amount'   => 0.0001,
                        'open'              => 0,
                        'low'               => 0,
                        'high'              => 0,
                        'close'             => 0,
                        'hrchange'          => 0,
                        'hrvolume'          => 0,
                        'active'            => 1,
                        'orderlist'         => 14,
                        'type'              => 0,
                        'created_at'        => date("Y-m-d H:i:s"),
                        'updated_at'        => date("Y-m-d H:i:s"),     
                    ]);    
              
                    DB::table('tradepairs')->insert(
                      [
                          'coinone'           => 'DASH',
                          'cointwo'           => 'USDT',
                          'min_buy_price'     => 0.001,
                          'min_buy_amount'    => 0.0001,
                          'min_sell_price'    => 0.001,
                          'min_sell_amount'   => 0.0001,
                          'open'              => 0,
                          'low'               => 0,
                          'high'              => 0,
                          'close'             => 0,
                          'hrchange'          => 0,
                          'hrvolume'          => 0,
                          'active'            => 1,
                          'orderlist'         => 15,
                          'type'              => 0,
                          'created_at'        => date("Y-m-d H:i:s"),
                          'updated_at'        => date("Y-m-d H:i:s"),     
                      ]);    
                    DB::table('tradepairs')->insert(
                      [
                          'coinone'           => 'XRP',
                          'cointwo'           => 'USDT',
                          'min_buy_price'     => 0.001,
                          'min_buy_amount'    => 0.0001,
                          'min_sell_price'    => 0.001,
                          'min_sell_amount'   => 0.0001,
                          'open'              => 0,
                          'low'               => 0,
                          'high'              => 0,
                          'close'             => 0,
                          'hrchange'          => 0,
                          'hrvolume'          => 0,
                          'active'            => 1,
                          'orderlist'         => 16,
                          'type'              => 0,
                          'created_at'        => date("Y-m-d H:i:s"),
                          'updated_at'        => date("Y-m-d H:i:s"),     
                      ]);  
                        DB::table('tradepairs')->insert(
                          [
                              'coinone'           => 'XMR',
                              'cointwo'           => 'USDT',
                              'min_buy_price'     => 0.001,
                              'min_buy_amount'    => 0.0001,
                              'min_sell_price'    => 0.001,
                              'min_sell_amount'   => 0.0001,
                              'open'              => 0,
                              'low'               => 0,
                              'high'              => 0,
                              'close'             => 0,
                              'hrchange'          => 0,
                              'hrvolume'          => 0,
                              'active'            => 1,
                              'orderlist'         => 17,
                              'type'              => 0,
                              'created_at'        => date("Y-m-d H:i:s"),
                              'updated_at'        => date("Y-m-d H:i:s"),     
                          ]);
                      DB::table('tradepairs')->insert(
                        [
                            'coinone'           => 'LIO',
                            'cointwo'           => 'USDT',
                            'min_buy_price'     => 0.001,
                            'min_buy_amount'    => 0.0001,
                            'min_sell_price'    => 0.001,
                            'min_sell_amount'   => 0.0001,
                            'open'              => 0,
                              'low'               => 0,
                              'high'              => 0,
                              'close'             => 0,
                              'hrchange'          => 0,
                              'hrvolume'          => 0,
                            'active'            => 1,
                            'orderlist'         => 18,
                            'type'              => 0,
                            'created_at'        => date("Y-m-d H:i:s"),
                            'updated_at'        => date("Y-m-d H:i:s"),     
                        ]);
                        DB::table('tradepairs')->insert(
                          [
                              'coinone'           => 'NAS',
                              'cointwo'           => 'USDT',
                              'min_buy_price'     => 0.001,
                              'min_buy_amount'    => 0.0001,
                              'min_sell_price'    => 0.001,
                              'min_sell_amount'   => 0.0001,
                              'open'              => 0,
                                'low'               => 0,
                                'high'              => 0,
                                'close'             => 0,
                                'hrchange'          => 0,
                                'hrvolume'          => 0,
                              'active'            => 1,
                              'orderlist'         => 19,
                              'type'              => 0,
                              'created_at'        => date("Y-m-d H:i:s"),
                              'updated_at'        => date("Y-m-d H:i:s"),     
                          ]); 
                          DB::table('tradepairs')->insert(
                            [
                                'coinone'           => 'QBC',
                                'cointwo'           => 'USDT',
                                'min_buy_price'     => 0.001,
                                'min_buy_amount'    => 0.0001,
                                'min_sell_price'    => 0.001,
                                'min_sell_amount'   => 0.0001,
                                'open'              => 0,
                                  'low'               => 0,
                                  'high'              => 0,
                                  'close'             => 0,
                                  'hrchange'          => 0,
                                  'hrvolume'          => 0,
                                'active'            => 1,
                                'orderlist'         => 20,
                                'type'              => 0,
                                'created_at'        => date("Y-m-d H:i:s"),
                                'updated_at'        => date("Y-m-d H:i:s"),     
                            ]);
                            DB::table('tradepairs')->insert(
                              [
                                  'coinone'           => 'EVX',
                                  'cointwo'           => 'USDT',
                                  'min_buy_price'     => 0.001,
                                  'min_buy_amount'    => 0.0001,
                                  'min_sell_price'    => 0.001,
                                  'min_sell_amount'   => 0.0001,
                                  'open'              => 0,
                                    'low'               => 0,
                                    'high'              => 0,
                                    'close'             => 0,
                                    'hrchange'          => 0,
                                    'hrvolume'          => 0,
                                  'active'            => 1,
                                  'orderlist'         => 21,
                                  'type'              => 0,
                                  'created_at'        => date("Y-m-d H:i:s"),
                                  'updated_at'        => date("Y-m-d H:i:s"),     
                              ]);  
      DB::table('tradepairs')->insert(
      [
          'coinone'           => 'BTC',
          'cointwo'           => 'ECPAY',
          'min_buy_price'     => 1000,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 1000,
          'min_sell_amount'   => 0.0001,
          'open'              => 0,
          'low'               => 0,
          'high'              => 0,
          'close'             => 0,
          'hrchange'          => 0,
          'hrvolume'          => 0,
          'active'            => 1,
          'orderlist'         => 22,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);

      DB::table('tradepairs')->insert(
      [
          'coinone'           => 'ETH',
          'cointwo'           => 'ECPAY',
          'min_buy_price'     => 90,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 80,
          'min_sell_amount'   => 0.0001,
          'open'              => 0,
          'low'               => 0,
          'high'              => 0,
          'close'             => 0,
          'hrchange'          => 0,
          'hrvolume'          => 0,
          'active'            => 1,
          'orderlist'         => 23,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);

      DB::table('tradepairs')->insert(
      [
          'coinone'           => 'LTC',
          'cointwo'           => 'ECPAY',
          'min_buy_price'     => 0.001,
          'min_buy_amount'    => 0.0001,
          'min_sell_price'    => 0.001,
          'min_sell_amount'   => 0.0001,
          'open'              => 0,
          'low'               => 0,
          'high'              => 0,
          'close'             => 0,
          'hrchange'          => 0,
          'hrvolume'          => 0,
          'active'            => 1,
          'orderlist'         => 24,
          'type'              => 0,
          'created_at'        => date("Y-m-d H:i:s"),
          'updated_at'        => date("Y-m-d H:i:s"),     
      ]);    

      DB::table('tradepairs')->insert(
        [
            'coinone'           => 'DASH',
            'cointwo'           => 'ECPAY',
            'min_buy_price'     => 0.001,
            'min_buy_amount'    => 0.0001,
            'min_sell_price'    => 0.001,
            'min_sell_amount'   => 0.0001,
            'open'              => 0,
            'low'               => 0,
            'high'              => 0,
            'close'             => 0,
            'hrchange'          => 0,
            'hrvolume'          => 0,
            'active'            => 1,
            'orderlist'         => 25,
            'type'              => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),     
        ]);    

      DB::table('tradepairs')->insert(
        [
            'coinone'           => 'USDT',
            'cointwo'           => 'ECPAY',
            'min_buy_price'     => 0.001,
            'min_buy_amount'    => 0.0001,
            'min_sell_price'    => 0.001,
            'min_sell_amount'   => 0.0001,
            'open'              => 0,
            'low'               => 0,
            'high'              => 0,
            'close'             => 0,
            'hrchange'          => 0,
            'hrvolume'          => 0,
            'active'            => 1,
            'orderlist'         => 26,
            'type'              => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),     
        ]); 
      DB::table('tradepairs')->insert(
        [
            'coinone'           => 'XRP',
            'cointwo'           => 'ECPAY',
            'min_buy_price'     => 0.001,
            'min_buy_amount'    => 0.0001,
            'min_sell_price'    => 0.001,
            'min_sell_amount'   => 0.0001,
            'open'              => 0,
            'low'               => 0,
            'high'              => 0,
            'close'             => 0,
            'hrchange'          => 0,
            'hrvolume'          => 0,
            'active'            => 1,
            'orderlist'         => 27,
            'type'              => 0,
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),     
        ]);  
          DB::table('tradepairs')->insert(
            [
                'coinone'           => 'XMR',
                'cointwo'           => 'ECPAY',
                'min_buy_price'     => 0.001,
                'min_buy_amount'    => 0.0001,
                'min_sell_price'    => 0.001,
                'min_sell_amount'   => 0.0001,
                'open'              => 0,
                'low'               => 0,
                'high'              => 0,
                'close'             => 0,
                'hrchange'          => 0,
                'hrvolume'          => 0,
                'active'            => 1,
                'orderlist'         => 28,
                'type'              => 0,
                'created_at'        => date("Y-m-d H:i:s"),
                'updated_at'        => date("Y-m-d H:i:s"),     
            ]);
        DB::table('tradepairs')->insert(
          [
              'coinone'           => 'LIO',
              'cointwo'           => 'ECPAY',
              'min_buy_price'     => 0.001,
              'min_buy_amount'    => 0.0001,
              'min_sell_price'    => 0.001,
              'min_sell_amount'   => 0.0001,
              'open'              => 0,
                'low'               => 0,
                'high'              => 0,
                'close'             => 0,
                'hrchange'          => 0,
                'hrvolume'          => 0,
              'active'            => 1,
              'orderlist'         => 29,
              'type'              => 0,
              'created_at'        => date("Y-m-d H:i:s"),
              'updated_at'        => date("Y-m-d H:i:s"),     
          ]);
          DB::table('tradepairs')->insert(
            [
                'coinone'           => 'NAS',
                'cointwo'           => 'ECPAY',
                'min_buy_price'     => 0.001,
                'min_buy_amount'    => 0.0001,
                'min_sell_price'    => 0.001,
                'min_sell_amount'   => 0.0001,
                'open'              => 0,
                  'low'               => 0,
                  'high'              => 0,
                  'close'             => 0,
                  'hrchange'          => 0,
                  'hrvolume'          => 0,
                'active'            => 1,
                'orderlist'         => 30,
                'type'              => 0,
                'created_at'        => date("Y-m-d H:i:s"),
                'updated_at'        => date("Y-m-d H:i:s"),     
            ]); 
            DB::table('tradepairs')->insert(
              [
                  'coinone'           => 'QBC',
                  'cointwo'           => 'ECPAY',
                  'min_buy_price'     => 0.001,
                  'min_buy_amount'    => 0.0001,
                  'min_sell_price'    => 0.001,
                  'min_sell_amount'   => 0.0001,
                  'open'              => 0,
                    'low'               => 0,
                    'high'              => 0,
                    'close'             => 0,
                    'hrchange'          => 0,
                    'hrvolume'          => 0,
                  'active'            => 1,
                  'orderlist'         => 31,
                  'type'              => 0,
                  'created_at'        => date("Y-m-d H:i:s"),
                  'updated_at'        => date("Y-m-d H:i:s"),     
              ]);
              DB::table('tradepairs')->insert(
                [
                    'coinone'           => 'EVX',
                    'cointwo'           => 'ECPAY',
                    'min_buy_price'     => 0.001,
                    'min_buy_amount'    => 0.0001,
                    'min_sell_price'    => 0.001,
                    'min_sell_amount'   => 0.0001,
                    'open'              => 0,
                      'low'               => 0,
                      'high'              => 0,
                      'close'             => 0,
                      'hrchange'          => 0,
                      'hrvolume'          => 0,
                    'active'            => 1,
                    'orderlist'         => 32,
                    'type'              => 0,
                    'created_at'        => date("Y-m-d H:i:s"),
                    'updated_at'        => date("Y-m-d H:i:s"),     
                ]);           
    }
}
