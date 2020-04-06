@extends('layouts.main')
@section('header')
    @include('header.header-user')
@endsection

@section('title', $item['title'])

@section('content')
    <h1>{{ $item['title'] }}</h1>

    {{--  Обращение к $GLOBALS['img-folder'] сделал чтобы не хранить в БД повторяющуюся информацию в каждой записи  --}}
    {{--  Или такие вещи лучше в конфиге хранить?  --}}
    @if($item['image'])
        <img src="{{ asset($GLOBALS['img-folder'] . $item['image']) }}" class="img-fluid d-block my-3">
    @else
        <img src="{{ asset($GLOBALS['img-folder'] . 'news-default.jpg') }}" class="img-fluid d-block my-3">
    @endif
    <p>{{ $item['content'] }}</p>
@endsection
