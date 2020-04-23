@extends('layouts.main')
@section('header')
    @include ('header.header')
@endsection

@section('title', $news_item->title)

@section('content')
    <h1>{{ $news_item->title }}</h1>
    @if($news_item->image)
        <img src="{{ asset($news_item::$img_folder . $news_item->image) }}" class="img-fluid d-block my-3 w-25">
    @else
        <img src="{{ asset($news_item::$img_folder . 'news-default.jpg') }}" class="img-fluid d-block my-3 w-25">
    @endif
    <p>{{ $news_item->text }}</p>
@endsection
