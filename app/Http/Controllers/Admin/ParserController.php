<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Jobs\NewsParsing;
use App\News;
use App\Http\Controllers\Controller;
use App\Services\XMLParserService;
use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Str;


class ParserController extends Controller
{
    //импорт новостей
    public function import(XMLParserService $parser)
    {
        $channels = ['news', 'articles', 'top7', 'last24', 'news/russia'];
        //усложним работу
//        for ($i = 0; $i < 50; $i++)
            foreach ($channels as $channel)
                NewsParsing::dispatch($channel);
        $alert = ['type' => 'success', 'text' => 'Задачи по импорту поставлены в очередь.'];
        return redirect()->route('admin.news.index')->with(['alert' => $alert]);
    }
}
