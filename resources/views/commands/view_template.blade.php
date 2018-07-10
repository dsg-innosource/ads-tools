/*
   description:
*/

use {{ $database_name }};

drop view if exists {{ $view_name }};

create view {{ $view_name }} as

   -- view code here
