@extends('layouts.main')
@section('title','Редактирование новости')
@section('header')
    @include('header.header-admin')
@endsection
@section('content')
        @if($edit_status === 'error')
            <h2 class="text-center text-danger">Ошибка редактирования</h2>
        @elseif($edit_status === 'ok')
            <h2 class="text-center text-success">Редактирование успешно</h2>
        @endif
        <form class="mx-auto col-8" method="post" action={{ route('admin.news.update') }}>
            @csrf
            <input type="hidden" name="id" value="{{ $news_item['id'] }}">
            <div class="form-group">
                <label for="news-name">Название новости</label>
                <input type="text" class="form-control" id="news-name" name="title" placeholder="Введите название новости" required value="{{ $news_item['title'] }}">
            </div>

            <div class="form-group">
                <label for="category">Категория</label>
                <select class="form-control" id="category" name="category" required>
                    <option disabled value=""
                        {{ $news_item['category'] === null ? 'selected' : ''  }}>
                        Выберите категорию
                    </option>
                    @foreach($categories as $category_item)
                        <option
                            {{ $news_item['category'] == $category_item['id'] ? 'selected' : ''  }}
                            value="{{ $category_item['id'] }}"
                        >
                            {{ $category_item['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="text">Текст новости</label>
                <textarea class="form-control" id="text" rows="15" name="content">{{ $news_item['content'] }}</textarea>
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

@endsection
