@extends('layouts.main')
@section('title','Добавление новости')
@section('header')
    @include('header.header-admin')
@endsection
@section('content')

    <div class="d-flex justify-content-center">
        <form class="col-8" method="post" action={{ route('admin.news.add') }}>
            <div class="form-group">
                <label for="news-name">Название новости</label>
                <input type="text" class="form-control" id="news-name" placeholder="Введите название новости" required>
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select class="form-control" id="category" required>
                    <option disabled selected>Выберите категорию</option>
                    @foreach($categories as $item)
                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="text">Текст новости</label>
                <textarea class="form-control" id="text" rows="3" ></textarea>
            </div>
{{--    Потом пригодится наверняка        --}}
{{--            <div class="form-group">--}}
{{--                <label for="exampleInputFile">File input</label>--}}
{{--                <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">--}}
{{--                <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the--}}
{{--                    above input. It's a bit lighter and easily wraps to a new line.</small>--}}
{{--            </div>--}}


            <button type="submit" class="btn btn-lg btn-primary ">Отправить</button>
        </form>
    </div>

@endsection
