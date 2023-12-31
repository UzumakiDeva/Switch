<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\BalanceTRXUpdate::class,
        Commands\LivePriceUpdate::class,
        Commands\DeletePendingPayment::class,
        Commands\UpdateBankExpired::class,
        Commands\UpdateLivePrizeDextrade::class,
        Commands\BuyTradeStatus::class,
        Commands\SellTradeStatus::class,
        Commands\UpdateTradeLivePrice::class,
        Commands\InsertStakeInterest::class,
		Commands\UpdateStakeOverll::class,
        Commands\InsertStakecto::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:buytrade')->everyMinute()->withoutOverlapping();
        $schedule->command('update:selltrade')->everyMinute()->withoutOverlapping();
        //$schedule->command('update:tradeprice')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('update:insertstakeinterest')->everyFiveMinutes()->withoutOverlapping();
		$schedule->command('update:stakeoverall')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('update:insertStakecto')->daily()->withoutOverlapping();
        $schedule->command('update:liveprice')->hourly()->withoutOverlapping();
        //$schedule->command('update:p2pexpired')->everyMinute()->withoutOverlapping();
        //$schedule->command('update:liveprizeDextrade')->everyMinute()->withoutOverlapping();
        //$schedule->command('delete:pendingpayment')->daily()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
