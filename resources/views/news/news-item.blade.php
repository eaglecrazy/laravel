@extends('layouts.main')

@section('header')
    @include('header.header-user')
@endsection

@section('title')
    {{ $item['title'] }}
@endsection

@section('content')
    <h1>{{ $item['title'] }}</h1>
    <p>{{ $item['content'] }}</p>
@endsection
