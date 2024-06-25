<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
   

class DatabaseBackUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d-H:i:s') . ".sql";
        $command = "mysqldump -p3306 -h " . env('DB_HOST') . " -u " . env('DB_USERNAME') ." --password='" . env('DB_PASSWORD') . "' " . env('DB_DATABASE') . "  > " . storage_path() . "/app/backupDB/". $filename;
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
    }
}
