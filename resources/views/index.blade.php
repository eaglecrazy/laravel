@extends('layouts.main')

@section('title')
    Главная страница
@endsection

@section('header')
    @include ('header.header-user')
@endsection

@section('content')
    <h1>Главная страница</h1>
    {{ Form::label('111') }}
@endsection
