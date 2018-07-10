<?php

namespace ResultData\ADSTools\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateStoredProcedures extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:procs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-deploy all stored procedures for the application.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $directory = config('ads-tools.directories.procs');

        if (!File::exists(base_path('/') . $directory)) {
            File::makeDirectory(base_path('/') . $directory, 0775, true);
        }

        $errors = 0;

        $procs = $this->getProcs($directory);

        if (!sizeof($procs)) {
            return $this->info('There are no stored procedures to deploy.');
        }

        for ($i = 1; $i < 3; $i++) {
            foreach ($procs as $proc) {
                $resp = $this->deployProc($directory . $proc, $i);
                if ($resp == 'error') {
                    $errors++;
                }
            }
        }

        if ($errors) {
            return $this->error('Check the log above, something went wrong!');
        }
    }

    public function getProcs($directory)
    {
        $procs = [];

        foreach (scandir($directory) as $file) {
            if (strtolower(substr($file, strlen($file) - 3, 3)) == 'sql') {
                array_push($procs, $file);
            }
        }

        return $procs;
    }

    public function deployProc($proc, $pass)
    {
        $sql = file_get_contents($proc);

        try {
            $resp = DB::connection()->getPdo()->exec($sql);

            if ($resp && $pass == 2) {
                $this->error('An error occured with "' . $proc . '"');
                return 'error';
            }
        } catch (Exception $e) {
        }

        if ($pass == 2) {
            $this->info('Deployed ' . $proc);
        }
    }
}
