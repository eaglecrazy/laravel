<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Jobs\NewsParsing;
use App\News;
use App\Http\Controllers\Controller;
use App\Services\XMLParserService;
use App\Task;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Str;


class ParserController extends Controller
{
    //импорт новостей
    public function import(XMLParserService $parser)
    {
        $channels = Task::all();
        foreach ($channels as $channel)
            NewsParsing::dispatch($channel['task']);
        $alert = ['type' => 'success', 'text' => 'Задачи по импорту поставлены в очередь.'];
        return redirect()->route('admin.news.index')->with(['alert' => $alert]);
    }
}
