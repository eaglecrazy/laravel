@extends('layouts.main')

@section('header')
    @include('header.header-user')
@endsection

@section('title')
{{-- Почему не работает эта конструкция? В заголовке страницы "1" --}}
{{--{{ $categoryName or 'Новости'}}--}}
{{-- поэтому сделал подлиннее --}}
{{ isset($categoryName) ? $categoryName : 'Новости' }}
@endsection



@section('content')

    @include('news.news-categories')

    @if (empty($categoryName))
        <h1>Новости</h1>
    @else
        <h1>Новости раздела {{ $categoryName }}</h1>
    @endif

    <div>
        @forelse ($news as $id => $item)
            <a href="{{ route('news.item', [App\Category::getCategoryLink($item['category']), $id]) }}">
                {{ $item['title'] }}
            </a>
            <br>
        @empty
            Новостей нет
        @endforelse
    </div>

@endsection

