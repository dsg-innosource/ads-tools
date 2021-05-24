<?php

namespace InnoSource\ADSTools\Console\Commands;

use Illuminate\Console\Command;

class Rebuild extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:rebuild';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the application.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('migrate:fresh');

        $this->call('migrate:procs');

        $this->call('migrate:functions');

        $this->call('migrate:views');
    }
}
