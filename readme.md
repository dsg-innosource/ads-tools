# ADS Tools

## Installation

You can install the ADS Tools via composer using the following steps:

1. Add the following snippet to the `repositories` section of your `composer.json` file:

```
    {
        "url": "https://github.com/resultdata/ads-tools.git",
        "type": "git"
    }
```

2. Add the package to your `composer.json` require list using:

```
    composer require resultdata/ads-tools
```

## Available Commands

| Command  | Action |
| ------------- | ------------- |
| `make:function` | Generates a SQL function using the database and function name provided |
| `make:proc` | Generates a SQL stored procedure using the database and procedure name provided |
| `make:sql-test` | Generates a SQL test file using the database, category, and test name provided |
| `make:view` | Generates a SQL view using the database and view name provided |
| `migrate:functions` | Creates all functions in the connected database |
| `migrate:procs` | Creates all stored procedures in the connected database |
| `migrate:rebuild` | Runs `migrate:fresh` and creates all views, stored procedures, and functions in the connected database |
| `migrate:views` | Creates all generated views in the connected database |
| `test:sql` | Runs all the available SQL test files and displays results |
