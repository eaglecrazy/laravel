@extends('layouts.main')
@section('title', 'Управление новостями')
@section('header')
    @include('header.header-admin')
@endsection
@section('content')
    <h1>Управление новостями</h1>
    <a href="#" class="btn btn-primary btn-lg mb-3" role="button">Добавить новость</a>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th>№</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Посмотреть</th>
            <th>Изменить</th>
            <th> Удалить </th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $id => $item)
            <tr>
            <th scope="row">1</th>
            <td>{{ $item['title'] }}</td>
            <td>{{ $categories[$item['category']]['name'] }}</td>
            <td><a href="{{ route('news.item', [ $categories[$item['category']]['link'], $id ]) }}" class="btn btn-success" role="button">Посмотреть</a></td>
            <td><a href="{{ route('admin.news.edit', $id) }}" class="btn btn-primary" role="button">Изменить</a></td>
            <td><a href="{{ route('admin.news.delete', $id) }}" class="btn btn-danger" role="button">Удалить</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection
