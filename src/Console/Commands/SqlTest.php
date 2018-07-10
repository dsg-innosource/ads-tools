<?php

namespace ResultData\ADSTools\Console\Commands;

use DB;
use Illuminate\Console\Command;

class SqlTest extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    // protected $name = 'test:sql';
    protected $signature = 'test:sql {--keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the SQL Tests.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $start = microtime(true);

        $directory = config('ads-tools.directories.tests');

        $tests = $this->getTests($directory);

        $this->bar = $this->output->createProgressBar(count($tests, COUNT_RECURSIVE) - sizeof($tests));

        $results = $this->runTests($tests);
        $this->info('');
        $this->table([
            'Category', 'File', 'Test', 'Result', 'Error', 'Seconds'
        ], $results);

        $col = collect($results);

        $errors = $col->filter(function ($test) { return $test['passes'] == 'Failed';})->count();
        $end = microtime(true);

        $time = round($end - $start, 2);

        if ($errors) {
            $this->error('Executed ' . $col->count() . ' ' . str_plural('test', $col->count()) . ' in ' . $time . ' seconds. ' .
             $errors . ' ' . str_plural('error', $errors) . '.');
        } else {
            $this->info('Executed ' . $col->count() . ' ' . str_plural('test', $col->count()) . ' in ' . $time . ' seconds. ' .
             $errors . ' ' . str_plural('error', $errors) . '.');
        }

        if (!$this->option('keep')) {
            $this->cleanUp();
        }
    }

    public function runTests($testCategories)
    {
        foreach ($testCategories as $category => $tests) {
            foreach ($tests as $index => $test) {
                $testResults[] = $this->runTest($test);
            }
        }

        return $testResults;
    }

    public function runTest($file)
    {
        $start = microtime(true);

        $split = explode('/', $file);
        $category = $split[2];
        $test = substr($split[3], 0, -4);
        $fileName = $file;
        $passes = 'Passes';
        $error = '';
        $sql = file_get_contents($file);
        $output = [];

        try {
            $resp = DB::connection()->getPdo()->exec($sql);

            if ($resp) {
                $error = 'There was an error running this test!';
                $passes = 'Failed';
            }
        } catch (Exception $e) {
        }

        try {
            $resp = DB::select(DB::raw("call $test;"));

            if ($resp) {
                $error = $resp[0]->error;
                $passes = 'Failed';
            }
        } catch (Exception $e) {
        }

        $end = microtime(true);

        $this->bar->advance();

        return [
            'category' => $category,
            'file' => $fileName,
            'test' => $test,
            'passes' => $passes,
            'error' => $error,
            'seconds' => number_format(round($end - $start, 2), 2)
        ];
    }

    public function getTests($top)
    {
        $directories = [];
        $tests = [];
        $contents = scandir($top);

        foreach ($contents as $content) {
            if (is_dir($top . $content) && $content !== '.' && $content !== '..') {
                $directories[] = $content;
            }
        }

        foreach ($directories as $directory) {
            $contents = scandir($top . $directory);

            foreach ($contents as $content) {
                if (!is_dir($top . '/' . $directory . '/' . $content)) {
                    $tests[$directory][] = $top . $directory . '/' . $content;
                }
            }
        }

        return $tests;
    }

    public function cleanUp()
    {
        $procs = DB::select(DB::raw("select
                                        *

                                    from
                                        information_schema.ROUTINES

                                    where
                                        routine_name like 'test_%';"));

        foreach ($procs as $proc) {
            DB::connection()->getPdo()->exec("drop procedure if exists $proc->ROUTINE_NAME;");
        }
    }
}
