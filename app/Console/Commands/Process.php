<?php

namespace App\Console\Commands;

use App\Http\Controllers\LawController;
use Illuminate\Console\Command;

class Process extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all transactions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        LawController::process();
    }
}
