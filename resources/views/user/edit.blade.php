@extends('layouts.main')

@section('title', 'Редактирование профиля')

@section('header')
    @include ('header.header')
@endsection

@if(session('alert'))
    @section('alert')
        @include('alert')
    @endsection
@endif

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Редактирование профиля</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.update', $user) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') ?? $user->name  }}" autocomplete="name">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') ?? $user->email }}" autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
{{--                        никто не может поменять свои данные без пароля --}}
{{--                        но админы могут менять чужие данные без ввода пароля--}}
                            @if (Auth::id() === $user->id)
                                <div class="form-group row">
                                    <label for="current-password" class="col-md-4 col-form-label text-md-right">Старый пароль</label>

                                    <div class="col-md-6">
                                        <input id="current-password" type="password"
                                               class="form-control @error('current-password') is-invalid @enderror" name="current-password" placeholder="заполнить обязательно">

                                        @error('current-password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           autocomplete="new-password" placeholder="можно не заполнять">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Подтвердите
                                    пароль</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="можно не заполнять">
                                </div>
                            </div>

                            @if(Auth::user()->role)
                                <div class="form-group row">
                                    <label for="user-role" class="col-md-4 col-form-label text-md-right">Администратор</label>
                                    <div class="col-md-6">
                                        <input id="user-role" type="checkbox" class="form-control" name="user-role" @if($user->role || old('user-role') === 'on') checked @endif @if (Auth::user()->role && Auth::id() === $user->id) disabled @endif >
                                    </div>
                                </div>
                            @endif
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
