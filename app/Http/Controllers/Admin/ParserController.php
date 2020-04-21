<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use Orchestra\Parser\Xml\Facade as XmlParser;
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
        $this->seedCategories($categories);
        $news = $this->setCategories($news);
        $this->seedNews($news);
        $alert = ['type' => 'success', 'text' => 'Импорт успешно завершён.'];
        return redirect()->route('news.all')->with(['alert' => $alert]);
    }

    // Парсить RSS c помощью XML парсера это как забивать гвозди рубанком! Я не нашёл ни одной
    // ленты, которая бы адекватно парсилась. :(
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
    private function seedNews($news)
    {
        foreach ($news as $news_item) {
            $new = new News();
            $new->fill($news_item);
            $new->save();
        }
    }

    //установка в новости id категорий вместо имён
    private function setCategories($news){
        foreach ($news as &$news_item)
            $news_item['category_id'] = Category::query()->where('name', $news_item['category_id'])->first()->id;
        return $news;
    }

    //заливка категорий в БД
    private function seedCategories($categories)
    {
        foreach ($categories as $categories_item) {
            if(Category::query()->where('name', $categories_item['name'])->first())
                continue;
            $newCategory = new Category();
            $newCategory->fill($categories_item);
            $newCategory->save();
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
                $newCategory['link'] = $this->translit_sef($categorieNames_item);
                $categories[] = $newCategory;
        }
        return $categories;
    }

    //генерация ЧПУ для категорий
    private function translit_sef($value)
    {
        $converter = array(
            'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
            'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
            'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
            'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
            'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
            'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
            'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
        );

        $value = mb_strtolower($value);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');

        return $value;
    }
}



