<?php

namespace InnoSource\ADSTools\Console\Commands;

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

        $procs = rglob(base_path($directory . '*.sql'));

        if (!count($procs)) {
            return $this->info('There are no stored procedures to deploy.');
        }

        for ($i = 1; $i < 3; $i++) {
            if (count($procs)) {
                $this->info("Starting Pass $i...");
                foreach ($procs as $proc) {
                    if ($this->deployProc($proc)) {
                        $procs = array_diff($procs, [$proc]);
                    }
                }
            }
        }

        if (count($procs)) {
            $this->line('');
            $this->error('We were unable to deploy the following procedures:');
            collect($procs)->each(function ($proc) {
                $proc_name = str_replace(base_path(config('ads-tools.directories.procs')), '', $proc);
                $this->comment('    : ' . $proc_name);
            });
            $this->error('Please review these procedures for any errors.');
            $this->line('');
        }
    }

    public function deployProc($proc)
    {
        $sql = file_get_contents($proc);
        $proc_name = str_replace(base_path(config('ads-tools.directories.procs')), '', $proc);

        $resp = DB::connection()->getPdo()->exec($sql);

        $this->output->writeln('<comment>Deploying:</comment>   ' . $proc_name);

        if ($resp) {
            $this->output->writeln('<error>Error:</error>       ' . $proc_name);
            return false;
        }

        $this->output->writeln('<info>Deployed:</info>    ' . $proc_name);
        return true;
    }
}
