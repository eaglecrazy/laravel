@extends('layouts.main')
@section('title','Добавление новости')
@section('header')
    @include('header.header-admin')
@endsection

@if(session('alert'))
    @section('alert')
        @include('alert')
    @endsection
@endif

@section('content')
    <form class="mx-auto" method="post" enctype="multipart/form-data" action={{ route('admin.news.add') }}>
        @csrf
        <div class="form-group">
            <label for="news-name">Название новости</label>
            <input type="text" class="form-control" id="news-name" name="title" placeholder="Введите название новости"
                   required value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="category">Категория</label>
            <select class="form-control" id="category" name="category" required>
                <option disabled value=""
                    {{ old('category') === null ? 'selected' : ''  }}
                >Выберите категорию
                </option>
                @foreach($categories as $category_item)
                    <option
                        value="{{ $category_item->id }}">{{ $category_item->name }}
                        {{ old('category') === $category_item->name ? 'selected' : ''  }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="text">Текст новости</label>
            <textarea class="form-control" id="text" rows="15" name="text" required>{{ old('text') }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Изображение</label>
            <input name="image" type="file" class="form-control-file" id="image">
        </div>


        <button type="submit" class="btn btn-lg btn-primary ">Отправить</button>
    </form>

@endsection
