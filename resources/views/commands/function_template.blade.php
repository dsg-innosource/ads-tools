

use {{ $database_name }};

drop function if exists {{ $function_name }};

CREATE FUNCTION {{ $function_name }}()

-- Function goes here