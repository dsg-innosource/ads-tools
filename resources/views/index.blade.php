@extends('ads-tools::layouts.ads-tools')

@section('content')
    <p class="mb-3">Welcome to ads-tools!</p>

    @foreach ($connections as $connection)
        <li><a href="/ads-tools/connections/{{ $connection['database'] }}">{{ $connection['database'] }}</a> ({{ $connection['driver'] }})</li>
    @endforeach
@endsection