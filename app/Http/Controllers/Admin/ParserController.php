<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Str;
//use SimpleXMLElement;


class ParserController extends Controller
{
    //импорт новостей
    public function import()
    {
        $news = $this->getNews();
        $categories = $this->getCategories($news);
        $this->addCategoriesToDB($categories);
        $news = $this->setCategories($news);
        $this->addNewsToDB($news);
        $alert = ['type' => 'success', 'text' => 'Импорт успешно завершён.'];
        return redirect()->route('news.all')->with(['alert' => $alert]);
    }

    //заливка новостей в БД
    private function addNewsToDB($news)
    {
        foreach ($news as $news_item) {
            News::firstOrCreate($news_item);
        }
    }

    //установка в новости id категорий вместо имён
    private function setCategories($news){
        foreach ($news as &$news_item)
            $news_item['category_id'] = Category::query()->where('name', $news_item['category_id'])->first()->id;
        return $news;
    }

    //заливка категорий в БД
    private function addCategoriesToDB($categories)
    {
        foreach ($categories as $categories_item) {
            Category::firstOrCreate($categories_item);
        }
    }

    //генерация массива категорий для бд
    private function getCategories($news)
    {
        $categorieNames = [];
        foreach ($news as $news_item) {
            if(!in_array($news_item['category_id'], $categorieNames))
                $categorieNames[] = $news_item['category_id'];
        }
        $categories = [];
        foreach ($categorieNames as $categorieNames_item) {
                $newCategory['name'] = $categorieNames_item;
                $newCategory['link'] = Str::slug($categorieNames_item);
                $categories[] = $newCategory;
        }
        return $categories;
    }




// Вот с этим у меня была большая  проблема. "enclosure::url", без "::url" элемент enclosure парсится как null.
// Лучше такие вещи показывать.
// А ещё я не понял, как спарсить массив сразу, спасибо, что на уроке показали пример. :)
    private function getNews()
    {
        $xml = XmlParser::load('https://lenta.ru/rss/news');
        $data = $xml->parse(
            [
                'news' => ['uses' => 'channel.item[title,link,description,pubDate,enclosure::url,category]']
            ]);
        $news = [];
        foreach ($data['news'] as $data_item){
            $news_item['title'] = $data_item['title'];
            $news_item['text'] = strip_tags(trim($data_item['description']));
            $news_item['category_id'] = $data_item['category'];
            $news_item['image'] = $data_item['enclosure::url'];
            $news_item['link'] = $data_item['link'];
            $news_item['date'] = (new \DateTime($data_item['pubDate']))->format('d.m.Y H:i:s');
            if(
                empty($news_item['title']) ||
                empty($news_item['text'])||
                empty($news_item['category_id'])||
                empty($news_item['image'])||
                empty($news_item['link'])||
                empty($news_item['date'])
            )
                continue;
            $news[] = $news_item;
        }
        return $news;
    }
}
