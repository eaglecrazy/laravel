@extends('layouts.main')

@section('title', 'Главная страница')

@section('header')
    @include ('header.header-user')
@endsection

@section('content')
    <table class="table">
        <tr>
            <td>Имя:</td>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <td>e-mail:</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td>Статус:</td>
            <td> user </td>
        </tr>
    </table>
    <a href="{{ route('user.edit', $user) }}" class="btn btn-primary btn-lg mb-3 mr-2" role="button">Изменить информацию</a>
@endsection
