<div>
    <h2>Разделы</h2>
    @foreach ($categories as $item)
        <a href="{{ route('news.category', $item['link']) }}">
            {{ $item['name'] }}
        </a>
        <br>
    @endforeach
</div>
<hr>

