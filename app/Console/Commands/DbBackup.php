<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Database Backup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    // public function handle()
    // {
    //     return Command::SUCCESS;
    // }
    public function handle()
    {
        // $filename = "backup-" . Carbon::now()->format('Y-m-d-H:i:s') . ".gz";
        $filename = "backup-" . Carbon::now()->format('Y-m-d-H:i:s') . ".gzip";
        $command = "mysqldump --users " . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . "--host= " . env('DB_HOST') ." " . env('DB_DATABASE') . "  || gzip > " . storage_path() . "/app/backupDB/". $filename;
        // $command = "mysqldump -p3306 -h " . env('DB_HOST') . " --u " . env('DB_USERNAME') ." --password='" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backupDB/". $filename;
        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);

        // return Command::SUCCESS;
    }
}
