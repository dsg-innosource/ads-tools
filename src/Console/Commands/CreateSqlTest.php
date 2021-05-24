<?php

namespace InnoSource\ADSTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateSqlTest extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:sql-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a sql test.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $directory = config('ads-tools.directories.tests');

        if (!File::exists(base_path('/') . $directory)) {
            File::makeDirectory(base_path('/') . $directory, 0775, true);
        }

        $database_name = $this->ask('What database is this test for?');

        $category_name = $this->ask('What category is this test for?');

        $test_name = $this->ask('What is the name of the test?');

        $file_name = strtolower(str_replace(' ', '_', $test_name)) . '.sql';

        $contents = view('ads-tools::commands.sql_test_template')
            ->with('database_name', $database_name)
            ->with('proc_name', $test_name)
            ->render();

        if (!file_exists($directory . '/' . $category_name)) {
            mkdir($directory . '/' . $category_name);
        }

        file_put_contents($directory . '/' . $category_name . '/' . $file_name, $contents);
    }
}
