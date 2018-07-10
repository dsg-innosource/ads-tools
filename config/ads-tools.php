<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ADS Tools Directories
    |--------------------------------------------------------------------------
    |
    | The directories listed here are used for the several console commands
    | that are used to generate stored procedures, views, and sql tests.
    | Given these are database operations the dir used is 'database'.
    |
    */

    'directories' => [
        'main' => env('ADS_MAIN_DIR', 'database/'),
        'functions' => env('ADS_FUNCTIONS_DIR', 'database/scripts/functions/'),
        'procs' => env('ADS_PROCS_DIR', 'database/scripts/procs/'),
        'scripts' => env('ADS_SCRIPTS_DIR', 'database/scripts/'),
        'tests' => env('ADS_TESTS_DIR', 'database/tests/'),
        'views' => env('ADS_VIEWS_DIR', 'database/scripts/views/'),
    ]
];
