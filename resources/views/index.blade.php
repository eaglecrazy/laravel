@extends('layouts.app')
{{--@extends('layouts.main')--}}

@section('title')
    @parent Главная страница
@endsection

@section('menu')
    @include ('menu')
@endsection

@section('content')
    <h1>Главная страница</h1>
@endsection
