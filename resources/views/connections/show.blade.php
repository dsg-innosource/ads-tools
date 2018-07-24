@extends('ads-tools::layouts.ads-tools')

@section('content')
    <connections-show :resource="{{json_encode($resource)}}"></connections-show>
@endsection