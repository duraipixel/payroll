<?php

namespace App\Console\Commands;

use App\Repositories\CronRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AttendanceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CronRepository $cron)
    {
        \Log::info("Cron is working fine!");
        // dd( $cron->getData() );
        $values = array('name' => 'Durairaj', 'created_at' => date('Y-m-d H:i:s'));
        DB::table('cron_tests')->insert($values);

        // \Log::info($cron->getData());
    }
}
