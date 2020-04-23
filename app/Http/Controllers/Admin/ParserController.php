<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use Orchestra\Parser\Xml\Facade as XmlParser;
use Illuminate\Support\Str;
use SimpleXMLElement;


class ParserController extends Controller
{
    //импорт новостей
    public function import()
    {
        $news = [];
        $news = $this->getChannelNews($news, 'internet');
        $news = $this->getChannelNews($news, 'cyber_sport');
        $news = $this->getChannelNews($news, 'music');
        $news = $this->getChannelNews($news, 'computers');
        $news = $this->getChannelNews($news, 'games');
        $categories = $this->getCategories($news);
        $this->addCategoriesToDB($categories);
        $news = $this->setCategories($news);
        $this->addNewsToDB($news);
        $alert = ['type' => 'success', 'text' => 'Импорт успешно завершён.'];
        return redirect()->route('news.all')->with(['alert' => $alert]);
    }

    // Парсить RSS c помощью XML парсера это как забивать гвозди рубанком! Я не нашёл ни одной
    // ленты, которая бы полностью парсилась XML парсером. :(
    // Наверняка есть специальные классы под это дело, а если без них то нормально парсить можно только регулярками.
    // В документации к Orchestra\Parser\Xml\Facade не нашёл как
    // перебрать все элементы, поэтому использовал нормальный парсер.
    private function getChannelNews($old_news, $channel)
    {
        $xml = new SimpleXMLElement(file_get_contents("https://news.yandex.ru/$channel.rss"));
        $category = str_replace('Яндекс.Новости: ', '', $xml->channel->title);
        $news = [];
        foreach ($xml->channel->item as $item) {
            $news_item['title'] = $item->title->__toString();
            $news_item['category_id'] = $category;
            $news_item['text'] = $item->description->__toString();
//            $news_item['link'] = $item->link->__toString();
            $news[] = $news_item;
        }
        return array_merge($old_news, $news);
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
    private function getCategories(array $news)
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
}



