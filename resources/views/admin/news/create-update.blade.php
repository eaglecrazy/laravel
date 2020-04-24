@extends('layouts.main')
@section('title')
    {{ $edit ? 'Изменение' : 'Добавление' }} новости
@endsection
@section('js')
    @if($errors->count())<script src="{{ asset('js/errors.js') }}" defer></script>@endif
@endsection

@section('header')
    @include ('header.header')
@endsection

@if(session('alert'))
    @section('alert')
        @include('alert')
    @endsection
@endif

@section('content')
{{--ВОПРОС. Почему то к @dump не применяются стили и он выглядит как на картинке dump.png в этой же папке. --}}
{{-- Это не критично, но @dump штука удобная и хотелось бы пользоваться ей по человечески :) --}}
{{--    {{  dd($errors) }} работает нормально --}}
{{--    @dump($errors)--}}

    <form class="mx-auto" method="post" enctype="multipart/form-data" action= {{ $edit ? route('admin.news.update', $news_item) : route('admin.news.store') }}>
        @csrf
        @if($edit) @method('put') @endif
        @if($edit)<input type="hidden" name="id" value="{{ $news_item->id }}">@endif
        <div class="form-group">
            <label for="news-name">Название новости</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="news-name" name="title" placeholder="Введите название новости" value="@if(old()){{ old('title') }}@elseif($edit){{ $news_item->title }}@endif" autofocus>
            @error('title')
                <div class="invalid-feedback">
                    @foreach($errors->get('title') as $error) {{ $error }}@endforeach
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category_id">Категория</label>
            <select class="form-control pr-5 @error('category_id') is-invalid @enderror" id="category" name="category_id">
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
            @error('category_id')
                <div class="invalid-feedback">
                    @foreach($errors->get('category_id') as $error) {{ $error }}@endforeach
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="text">Текст новости</label>
            <textarea class="form-control @error('text') is-invalid @enderror" id="text" rows="6" name="text">@if(old()){{ old('text') }}@elseif($edit){{ $news_item->text }}@endif</textarea>
            @error('text')
                <div class="invalid-feedback">
                    @foreach($errors->get('text') as $error) {{ $error }}@endforeach
                </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Изображение</label>
            @if(session('temp_image')) <input type="hidden" name="temp-image" value="{{ session('temp_image') }}"> @endif
            <img class="img-fluid d-block w-75 mb-3" alt=""
                @if(session('temp_image'))
                    src="{{ asset(session('temp_image')) }}"
                @elseif($edit)
                    @if($news_item->image)
                        src="@if(parse_url($news_item->image)) {{ $news_item->image }} @else {{ asset($news_item::$img_folder . $news_item->image) }} @endif "
                    @else
                        src="{{ asset($news_item::$img_folder . 'news-default.jpg') }}"
                    @endif
                @endif
            >
            <input name="image" type="file" class="form-control-file  @error('image') is-invalid @enderror" id="image">
            @error('image')
                <div class="invalid-feedback">
                    @foreach($errors->get('image') as $error) {{ $error }}@endforeach
                </div>
            @enderror
            </div>
        <button type="submit" class="btn btn-lg btn-primary ">{{ $edit ? 'Сохранить' : 'Отправить' }}</button>
    </form>
@endsection
