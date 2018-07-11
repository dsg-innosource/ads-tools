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

        $currentEnvDB = config('database.connections.' . config('database.default') . '.database');

        $database_name = $this->ask('What database is this proc for?', $currentEnvDB);

        $category_name = $this->anticipate('What category is this test for? (tier1, tier2, etc)', ['tier1', 'tier2'], '');

        $proc_name = $this->ask('What is the name of the procedure?');

        if (!$proc_name) {
            $this->error('Procedure name is required!');
            die();
        }

        $file_name = strtolower(str_replace(' ', '_', $proc_name)) . '.sql';

        $contents = view('ads-tools::commands.proc_template')
                    ->with('database_name', $database_name)
                    ->with('proc_name', $proc_name)
                    ->render();

        if ($category_name) {
            $category_path = $directory . '/' . $category_name;
            $file_path = $category_path . '/' . $file_name;

            if (!File::exists($category_path)) {
                File::makeDirectory($category_path, 0775, true);
            }
        } else {
            $file_path = $directory . '/' . $file_name;
        }

        file_put_contents($file_path, $contents);
    }
}
