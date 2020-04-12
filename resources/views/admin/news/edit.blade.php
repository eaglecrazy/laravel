@extends('layouts.main')
@section('title','Редактирование новости')
@section('header')
    @include('header.header-admin')
@endsection

@if(session('alert'))
    @section('alert')
        @include('alert')
    @endsection
@endif

@section('content')
        <form class="mx-auto col-8" method="post" enctype="multipart/form-data" action={{ route('admin.news.update') }}>
            @csrf
            <input type="hidden" name="id" value="{{ $news_item }}">
            <div class="form-group">
                <label for="news-name">Название новости</label>
                <input type="text" class="form-control" id="news-name" name="title" placeholder="Введите название новости" value="{{ $news_item->title }}">
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select class="form-control" id="category" name="category">
                    <option disabled value=""
                        {{ $news_item->category === null ? 'selected' : ''  }}>
                        Выберите категорию
                    </option>
                    @foreach($categories as $category_item)
                        <option {{ $news_item->category == $category_item->id ? 'selected' : '' }} value="{{ $category_item->id }}"> {{ $category_item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="text">Текст новости</label>
                <textarea class="form-control" id="text" rows="15" name="text">{{ $news_item->text }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Изображение</label>
                @if($news_item->image)
                    <img src="{{ asset($GLOBALS['img-folder'] . $news_item->image) }}" class="img-fluid d-block w-75 mb-3" alt="">
                @else
                    <img src="{{ asset($GLOBALS['img-folder'] . 'news-default.jpg') }}" class="img-fluid d-block w-75 mb-3" alt="">
                @endif
                <input type="file" class="form-control-file" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-lg btn-primary">Сохранить</button>
        </form>

@endsection
