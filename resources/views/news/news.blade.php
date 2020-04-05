@extends('layouts.main')

@section('header')
    @include('header.header-user')
@endsection

@section('title')
    {{ $categoryName ?? 'Новости'}}
@endsection


@section('content')

    <div>
        <h2>Разделы</h2>
        @foreach ($categories as $item)
            <a href="{{ route('news.category', $item['link']) }}">
                {{ $item['name'] }}
            </a>
            <br>
        @endforeach
    </div>
    <hr>

    @if (empty($categoryName))
        <h1>Новости</h1>
    @else
        <h1>Новости раздела {{ $categoryName }}</h1>
    @endif

    <div class="col-10">
        @forelse ($news as $id => $item)
            <div class="pl-2 my-4">
                <a href="{{ route('news.item', [ $categories[$item['category']]['link'], $id ]) }}">
                    <h2>{{ $item['title'] }}</h2>
                    <img src="{{ $item['image'] ?? asset('storage/images/news-default.jpg') }}" class="img-fluid d-block my-3 w-50">
                </a>
                <br>
            </div>
        @empty
            Новостей нет
        @endforelse
    </div>

@endsection

