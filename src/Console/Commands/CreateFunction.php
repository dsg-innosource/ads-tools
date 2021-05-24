<?php

namespace InnoSource\ADSTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateFunction extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:function';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a function.';

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

        $database_name = $this->ask('What database is this function for?');

        $function_name = $this->ask('What is the name of the function?');

        $file_name = strtolower(str_replace(' ', '_', $function_name)) . '.sql';

        $contents = view('ads-tools::commands.function_template')
                    ->with('database_name', $database_name)
                    ->with('function_name', $function_name)
                    ->render();

        file_put_contents($directory . $file_name, $contents);
    }
}
