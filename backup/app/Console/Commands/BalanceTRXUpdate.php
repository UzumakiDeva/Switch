<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Traits\TrcClass;

class BalanceTRXUpdate extends Command
{
    use TrcClass;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:trx';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update TRX transaction for logged Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
    */
    public function handle()
    {
        $users = User::get();
        foreach ($users as $key => $user) {
            $this->UpdateTransaction($user->id);
        }        
        $this->info('TRX transaction updated to All Users');
    }
}
