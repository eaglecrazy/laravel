@extends('layouts.main')

@if($edit)
    @section('title', 'Редактирование ресурса')
@else
    @section('title', 'Добавление ресурса')
@endif

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
                    <div class="card-header">{{ $edit ? 'Редактирование' : 'Добавление' }} ресурса</div>
                    <div class="card-body">
                        <form method="POST" action="{{ $edit ? route('admin.tasks.update', $task) : route('admin.tasks.store') }}">
                            @csrf
                            @if($edit) @method('PUT') @endif
                            @if($edit)<input type="hidden" name="id" value="{{ $task->id }}">@endif
                            <div class="form-group row">
                                <label for="task" class="col-md-4 col-form-label text-md-right">Ресурс</label>
                                <div class="col-md-6">
                                    <input id="task" type="text"
                                           class="form-control @error('task') is-invalid @enderror" name="task"
                                           value="{{ old() ? old('task') : $task->task ?? ''}}">
                                    @error('task')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
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
