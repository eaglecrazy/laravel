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

        @php $number = ($news->currentPage()-1) * $news->perPage() + 1; @endphp
        @foreach($news as $news_item)
            <tr>
                <th scope="row">{{ $number++ }}</th>
                <td>{{ $news_item->title }}</td>
                <td>{{ $categories[$news_item->category_id]->name }}</td>
                <td><a href="{{ route('news.item', [$categories[$news_item->category_id]->link, $news_item]) }}" class="btn btn-success" role="button">Посмотреть</a></td>
                <td><a href="{{ route('admin.news.edit', $news_item) }}" class="btn btn-primary" role="button">Изменить</a></td>
{{--                <td><a href="{{ route('admin.news.destroy', $news_item) }}" class="btn btn-danger" role="button">Удалить</a></td>--}}
                <td>

                    <form action="{{ route('admin.news.destroy', $news_item) }}" method="post" enctype="multipart/form-data">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $news->links() }}


@endsection
