@extends('ads-tools::layouts.ads-tools')

@section('content')
    <p class="mb-3">{{ $connection->getConnectionName() }}</p>

    <div class="w-1/2 bg-white p-2 flex flex-col text-sm text-grey-darkest">
        <div class="uppercase text-grey-dark text-xs flex p-1 border-b">
            <div class="w-1/3">Table Name</div>
            <div class="w-1/3">Type</div>
            <div class="w-1/3">Rows</div>
        </div>
        @foreach ($connection->tables as $table)
            <div class="flex px-1 py-2 hover:bg-grey-lighter">
                <div class="w-1/3">{{ $table->name }}</div>
                <div class="w-1/3">{{ $table->type }}</div>
                <div class="w-1/3">{{ $table->rowCount }}</div>
            </div>
        @endforeach
    </div>
    
@endsection