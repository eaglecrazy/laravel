@extends('layouts.main')
@section('header')
    @include('header.header-user')
@endsection

@section('title', $item['title'])

@section('content')
    <h1>{{ $item['title'] }}</h1>
    <img src="{{ $item['image'] ?? asset('storage/images/news-default.jpg') }}" class="img-fluid d-block my-3">
    <p>{{ $item['content'] }}</p>
@endsection
