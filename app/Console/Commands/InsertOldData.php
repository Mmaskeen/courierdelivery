<?php

namespace App\Console\Commands;

use App\Imports\ImportOldData;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class InsertOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:oldData { --file_name= : File Name to import "Contains in public/imports"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import data from cvs file';

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
    {$fileName = $this->option('file_name');

        if ($fileName == null){
            return $this->info('file_name= parameter is required to identify file');
        }

        //file name = Corso.csv
        if (!is_null($fileName)){
            $filePath = public_path('uploads/'.$fileName);
        }

        $confirmation = $this->ask("Do you want to proceed?",
            '"Y" to Proceed, "N" to Cancel');

        if (strtoupper($confirmation) == 'N'){
            return $this->info('Operation Canceled.');
        }

        if (strtoupper($confirmation) == "Y"){
            Excel::import(new ImportOldData($this->output), $filePath);
            return $this->info('Successful.');
        }
    }
}
