<?php

namespace InnoSource\ADSTools\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateViews extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-deploy all database views for the application.';

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

        $views = $this->getViews($directory);

        if (!sizeof($views)) {
            return $this->info('There are no views to deploy.');
        }

        for ($i = 1; $i < 3; $i++) {
            foreach ($views as $view) {
                $this->deployView($directory . $view, $i);
            }
        }
    }

    public function getViews($directory)
    {
        $views = [];

        foreach (scandir($directory) as $file) {
            if (strtolower(substr($file, strlen($file) - 3, 3)) == 'sql') {
                array_push($views, $file);
            }
        }

        return $views;
    }

    public function deployView($view, $pass)
    {
        $sql = file_get_contents($view);

        try {
            $resp = DB::connection()->getPdo()->exec($sql);

            if ($resp && $pass == 2) {
                return $this->error('An error occured with "' . $view . '"');
            }
        } catch (Exception $e) {
            dd($e);
        }

        if ($pass == 2) {
            $this->info('Deployed ' . $view);
        }
    }
}
