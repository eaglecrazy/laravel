@extends('layouts.app')
@section('title')
    {{ $item['title'] }}
@endsection
@section('menu')
    @include('menu')
@endsection
@section('content')
    <h1>{{ $item['title'] }}</h1>
    <p>{{ $item['content'] }}</p>
@endsection
