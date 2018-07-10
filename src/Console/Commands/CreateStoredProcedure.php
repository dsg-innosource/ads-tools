<?php

namespace ResultData\ADSTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateStoredProcedure extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:proc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a stored procedure.';

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

        $database_name = $this->ask('What database is this proc for?');

        $proc_name = $this->ask('What is the name of the proc?');

        $file_name = strtolower(str_replace(' ', '_', $proc_name)) . '.sql';

        $contents = view('ads-tools::commands.proc_template')
                    ->with('database_name', $database_name)
                    ->with('proc_name', $proc_name)
                    ->render();

        file_put_contents($directory . $file_name, $contents);
    }
}
