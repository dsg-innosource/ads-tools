<?php

namespace InnoSource\ADSTools\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateFunctions extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:functions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-deploy all functions for the application.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $directory = config('ads-tools.directories.functions');

        if (!File::exists(base_path('/') . $directory)) {
            File::makeDirectory(base_path('/') . $directory, 0775, true);
        }

        $errors = 0;

        $functions = $this->getFunctions($directory);

        if (!sizeof($functions)) {
            return $this->info('There are no functions to deploy.');
        }

        for ($i = 1; $i < 3; $i++) {
            foreach ($functions as $function) {
                $resp = $this->deployFunction($directory . $function, $i);
                if ($resp == 'error') {
                    $errors++;
                }
            }
        }

        if ($errors) {
            return $this->error('Check the log above, something went wrong!');
        }
    }

    public function getFunctions($directory)
    {
        $functions = [];

        foreach (scandir($directory) as $file) {
            if (strtolower(substr($file, strlen($file) - 3, 3)) == 'sql') {
                array_push($functions, $file);
            }
        }

        return $functions;
    }

    public function deployFunction($function, $pass)
    {
        $sql = file_get_contents($function);

        try {
            $resp = DB::connection()->getPdo()->exec($sql);

            if ($resp && $pass == 2) {
                $this->error('An error occured with "' . $function . '"');
                return 'error';
            }
        } catch (Exception $e) {
        }

        if ($pass == 2) {
            $this->info('Deployed ' . $function);
        }
    }
}
