@extends('layouts.main')
@section('title', 'Управление пользователями')
@section('header')
    @include ('header.header')
@endsection

@if(session('alert'))
@section('alert')
    @include('alert')
@endsection
@endif

@section('content')

    <h1>Управление пользователями</h1>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th>№</th>
            <th>Имя</th>
            <th>E-mail</th>
            <th>Статус</th>
            <th>Посмотреть</th>
            <th>Изменить</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody>

        @php $number = ($users->currentPage()-1) * $users->perPage() + 1; @endphp
        @foreach($users as $users_item)
            <tr>
                <th scope="row">{{ $number++ }}</th>
                <td>{{ $users_item->name }}</td>
                <td>{{ $users_item->email }}</td>
                <td>{{ ($users_item->role === 1) ? 'admin' : 'user' }}</td>
                <td>
                    <a href="{{ route('user.show', $users_item) }}" class="btn btn-success" role="button">Посмотреть</a></td>
                <td>
                    <a href="{{ route('user.edit', $users_item) }}" class="btn btn-primary" role="button">Изменить</a>
                </td>
                <td>
                    @if(Auth::user()->id !== $users_item->id)
                    <form action="{{ route('user.destroy', $users_item) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}


@endsection
