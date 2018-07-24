@extends('ads-tools::layouts.ads-tools')

@section('content')
    <connections-index :connections="{{json_encode($connections)}}" base-url="{{route('ads-tools.connections.index')}}"></connections-index>
@endsection