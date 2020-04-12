@extends('layouts.main')
@section('title')
    {{ $edit ? 'Изменение' : 'Добавление' }} новости
@endsection

@section('header')
    @include('header.header-admin')
@endsection

@if(session('alert'))
    @section('alert')
        @include('alert')
    @endsection
@endif

@section('content')
    <form class="mx-auto" method="post" enctype="multipart/form-data"
          action= {{ $edit ? route('admin.news.update', $news_item) : route('admin.news.add') }}>
        @csrf
        @if($edit)<input type="hidden" name="id" value="{{ $news_item->id }}">@endif
        <div class="form-group">
            <label for="news-name">Название новости</label>
            <input type="text" class="form-control" id="news-name" name="title" placeholder="Введите название новости"
                   value="@if(old('title')){{ old('title') }}@elseif($edit){{ $news_item->title }}@endif">
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select class="form-control" id="category" name="category_id">
                <option disabled value=""
                @if($edit)
                    {{ $news_item->category_id === null ? 'selected' : ''  }}
                @else
                    {{ old('category_id') === null ? 'selected' : ''  }}
                @endif
                >Выберите категорию
                </option>
                @foreach($categories as $category_item)
                    <option
                        value="{{ $category_item->id }}"
                        {{-- выбор какую опцию обозначить как selected --}}
                        @if(old('category_id'))
                            {{ old('category_id') == $category_item->id ? 'selected' : '' }}
                        @elseif($edit)
                            {{ $news_item->category_id == $category_item->id  ? 'selected' : '' }}
                        @endif
                    >
                        {{ $category_item->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="text">Текст новости</label>
            <textarea class="form-control" id="text" rows="6" name="text">@if(old('text')){{ old('text') }}@elseif($edit){{ $news_item->text }}@endif</textarea>
        </div>
        <div class="form-group">
            <label for="image">Изображение</label>
            @if(session('temp_image')) <input type="hidden" name="temp-image" value="{{ session('temp_image') }}"> @endif
            <img class="img-fluid d-block w-75 mb-3" alt=""
                @if(session('temp_image'))
                    src="{{ asset(session('temp_image')) }}"
                @elseif($edit)
                    @if($news_item->image)
                        src="{{ asset($news_item::$img_folder . $news_item->image) }}"
                    @else
                        src="{{ asset($news_item::$img_folder . 'news-default.jpg') }}"
                    @endif
                @endif
            >
                <input name="image" type="file" class="form-control-file" id="image">
            </div>
        <button type="submit" class="btn btn-lg btn-primary ">{{ $edit ? 'Сохранить' : 'Отправить' }}</button>
    </form>

@endsection
