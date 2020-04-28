@extends('layouts.main')
@section('header')
    @include ('header.header')
@endsection

@section('title', $news_item->title)

@section('content')
    <h1>{{ $news_item->title }}</h1>
    @if($news_item->image)
        <img src="@if(parse_url($news_item->image)) {{ $news_item->image }} @else {{ asset($news_item::$img_folder . $news_item->image) }} @endif " class="img-fluid d-block my-3 w-50">
    @else
        <img src="{{ asset($news_item::$img_folder . 'news-default.jpg') }}" class="img-fluid d-block my-3 w-50">
    @endif
    <p>{!! $news_item->text !!}</p>
    <p>{{ $news_item->date }}</p>
    <a href="{{ $news_item->link }}" class="btn btn-primary btn-lg mb-3 mr-2" role="button">Полный текст новости</a>


@endsection
