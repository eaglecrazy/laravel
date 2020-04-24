@extends('layouts.main')
@section('title', 'Управление пользователями')
@section('header')
    @include ('header.header')
@endsection
@section('js')
    <script src="{{ asset('js/my.js') }}" defer></script>
@endsection

@if(session('alert'))
@section('alert')
    @include('alert')
@endsection
@endif

@section('content')
    <div class="alert-place"></div>

    <h1>Управление пользователями</h1>
    <table class="table table-striped table-hover">
        <thead class="thead-dark">
        <tr>
            <th>№</th>
            <th>Имя</th>
            <th>E-mail</th>
            <th>Администратор (асинхронно)</th>
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
                <td class="text-center">
                    @if(Auth::user()->id !== $users_item->id)
                    <input type="checkbox" class="check-role" {{ ($users_item->role === 1) ? 'checked' : '' }} data-id="{{ $users_item->id }}">
                    @endif
                </td>
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
