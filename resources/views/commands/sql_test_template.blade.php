use {{ $database_name }};

drop procedure if exists {{ $proc_name }};

-- DELIMITER ;;
create procedure {{ $proc_name }}()

this_proc:begin

    select '{{ $proc_name }} is not implemented' as error;

end
