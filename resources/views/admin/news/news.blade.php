@extends('layouts.main')
@section('title', 'Управление новостями')
@section('header')
    @include('header.header-admin')
@endsection

@if(session('alert'))
@section('alert')
    @include('alert')
@endsection
@endif

@section('content')

    <h1>Управление новостями</h1>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-lg mb-3 mr-2" role="button">Добавить
        новость</a>
    <a href="{{ route('admin.news.export') }}" class="btn btn-primary btn-lg mb-3" role="button">Экспорт новостей</a>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th>№</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Посмотреть</th>
            <th>Изменить</th>
            <th> Удалить</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $news_item)
            <tr>
                <th scope="row">{{ $news_item->number }}</th>
                <td>{{ $news_item->title }}</td>
                <td>{{ $categories[$news_item->category]->name }}</td>
                <td><a href="{{ route('news.item', [$categories[$news_item->category]->link, $news_item->id ]) }}"
                       class="btn btn-success" role="button">Посмотреть</a></td>
                <td><a href="{{ route('admin.news.edit', $news_item->id) }}" class="btn btn-primary"
                       role="button">Изменить</a></td>
                <td><a href="{{ route('admin.news.delete', $news_item->id) }}" class="btn btn-danger"
                       role="button">Удалить</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
