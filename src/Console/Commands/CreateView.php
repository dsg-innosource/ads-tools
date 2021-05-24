<?php

namespace InnoSource\ADSTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateView extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a view.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $directory = config('ads-tools.directories.views');

        if (!File::exists(base_path('/') . $directory)) {
            File::makeDirectory(base_path('/') . $directory, 0775, true);
        }

        $database_name = $this->ask('What database is this view for?');

        $view_name = $this->ask('What is the name of the view?');

        $file_name = strtolower(str_replace(' ', '_', $view_name)) . '.sql';

        $contents = view('ads-tools::commands.view_template')
                    ->with('database_name', $database_name)
                    ->with('view_name', $view_name)
                    ->render();

        file_put_contents($directory . $file_name, $contents);
    }
}
