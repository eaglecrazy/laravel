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

    <div>
        @forelse ($news as $id => $item)
            <a href="{{ route('news.item', [$item['category'], $id]) }}">
                {{ $item['title'] }}
            </a>
            <br>
        @empty
            Новостей нет
        @endforelse
    </div>

@endsection

