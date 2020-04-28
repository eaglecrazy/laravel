@extends('layouts.main')

@section('header')
    @include('header.header')
@endsection

@section('title')
    {{ $categoryName ?? 'Новости'}}
@endsection

@section('css')
    <link href="{{ asset('/css/news.css') }}" rel="stylesheet">
@endsection

@section('content')
    <h2>Разделы</h2>
    <div class="text-center">
        @foreach ($categories as $category_item)
            <a class="btn btn-info m-2" href="{{ route('news.category', $category_item->link) }}">
                {{ $category_item->name }}
            </a>
        @endforeach
    </div>
    <hr>

    @if (empty($categoryName))
        <h1>Новости</h1>
    @else
        <h1>Новости раздела {{ $categoryName }}</h1>
    @endif

    <div class="col-12">
        @forelse ($news as $news_item)
            <div class="p-3 news-hover mx-auto rounded news-hover">
                <a class="news-link" href="{{ route('news.item', [$categories[$news_item->category_id]->link, $news_item]) }}">
                    <h2>{{ $news_item->title }}</h2>
                    @if($news_item->image)
                        <img src="@if(parse_url($news_item->image)) {{ $news_item->image }} @else {{ asset($news_item::$img_folder . $news_item->image) }} @endif "
                             class="img-fluid d-block my-3 w-25 rounded">
                    @else
                        <img src="{{ asset($news_item::$img_folder . 'news-default.jpg') }}"
                             class="img-fluid d-block my-3 w-25">
                    @endif
                </a>
                <br>
            </div>
        @empty
            Новостей нет
        @endforelse

        {{ $news->links() }}
    </div>

@endsection

