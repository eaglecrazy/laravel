@extends('layouts.main')
@section('title', 'Управление задачами')
@section('header')
    @include ('header.header')
@endsection

@if(session('alert'))
@section('alert')
    @include('alert')
@endsection
@endif

@section('content')
    <h1>Управление ресурсами</h1>
    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-lg mb-3 mr-2" role="button">Добавить
        ресурс</a>
    <table class="table table-striped table-hover col-md-8 mx-auto">
        <thead class="thead-dark">
        <thead class="thead-dark">
        <tr>
            <th>№</th>
            <th>Название</th>
            <th>Изменить</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>

        @php $number = 1; @endphp
        @foreach($tasks as $tasks_item)
            <tr>
                <th scope="row">{{ $number++ }}</th>
                <td>{{ $tasks_item->task }}</td>
                <td><a href="{{ route('admin.tasks.edit', $tasks_item) }}" class="btn btn-primary"
                       role="button">Изменить</a></td>
                <td>
                    <form action="{{ route('admin.tasks.destroy', $tasks_item) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
