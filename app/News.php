<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


const FILE = '/home/vagrant/code/laravel/resources/files/news.json';


class News extends Model
{
//    private static $news = [
//        1 =>
//            [
//                'id' => '1',
//                'title' => 'Удивительный стакан',
//                'content' => 'Брату Владимира из Апатитов Максиму достался стакан с пепси, у которого в крышке два отверстия для трубочек. "Да это ещё и не пепси, а Кока-Кола!!!"— выразил своё недовольство работой учреждения общепита Максим.',
//                'category' => 1
//            ],
//        2 =>
//            [
//                'id' => '2',
//                'title' => 'Перепутал',
//                'content' => 'Михаил из Санкт-Петербурга решил помыть руки в общественном месте, но перепутал жидкое мыло с лосьоном для рук. "Честно, это было шоком для меня! Но ведь бутылочки - они же так похожи! - делится переживаниями потерпевший - Никому не желаю столкнуться с такой же ситуацией в жизни...". К сожалению, управляющий данной уборной комнаты отказался от общения с журналистами по данному вопросу.',
//                'category' => 2
//            ],
//        3 =>
//            [
//                'id' => '3',
//                'title' => 'Вкусный завтрак',
//                'content' => 'Оля из Москвы попыталась приготовить омлет. " Чуть не подожгла весь дом, испачкала всю плиту и посуду, испортила сковородку, обожгла палец. Омлет получился некрасивым, но довольно вкусным." - комментирует москвичка.',
//                'category' => 1
//            ],
//
//        4 =>
//            [
//                'id' => '4',
//                'title' => 'Странный орех',
//                'content' => 'Пятого февраля где-то в Красноярске коренной красноярец Павел Солусенко , сидя у себя на кухне, предавался употреблению грецких орехов. Неожиданно глазам серийного поедателя предстал орех совершенно странного вида. "Это невероятно, поражён до глубины души." - прокомментировал данное происшествие наш герой.',
//                'category' => 1
//            ],
//        5 =>
//            [
//                'id' => '5',
//                'title' => 'Неудачное чаепитие',
//                'content' => 'У Екатерины из Смоленска порвался чайный пакетик и почти весь чай просыпался на пол. "Это было неожиданно, а второго пакетика у меня с собой не оказалось", - с расстройством подмечает девушка.',
//                'category' => 1
//            ],
//    ];


    public static function getNewsAll()
    {
        $json = file_get_contents(FILE);
        return json_decode($json, true);

    }

    public static function getNewsItem($id)
    {
        $news = static::getNewsAll();
        if (array_key_exists($id, $news))
            return $news[$id];
        return null;
    }

    public static function getNewsByCategory($category)
    {
        $result = [];
        $news = static::getNewsAll();
        foreach ($news as $id => $item) {
            if ($item['category'] == $category)
                $result[$id] = $item;
        }
        return $result;
    }

    //метод меняем id категории на link во всех новостях
//    public static function changeCategoryIdToLink(array $news)
//    {
//        //работаем не с копией, а с исходным массивом
//        foreach ($news as &$item){
//            $item['category'] = Category::getCategoryLink($item['category']);
//        }
//        return $news;
//    }

    //добавляем нумерацию всем новостям
    public static function addNumeration($news)
    {
        $n = 1;
        foreach ($news as &$item) {
            $item['number'] = $n++;
        }
        return $news;
    }

    public static function saveNews($new)
    {
        $news = News::getNewsAll();
        $new['id'] = (int)$news[count($news)]['id'] + 1;
        $news[] = $new;
        $json = json_encode($news, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        file_put_contents(FILE, $json);
    }

    //проверка есть ли ошибки в новости
    public static function thereIsError($new)
    {
        return true;
        //проверка существования ключей
        if (!array_key_exists('title', $new) || !array_key_exists('category', $new) || !array_key_exists('content', $new))
            return true;
        //проверка на пустые значения
        if ($new['title'] == '' || $new['category'] == '' || $new['content'] == '')
            return true;
        //проверка на существование в категориях $new['category']
        if (empty(Category::getCategoryName($new['category'])))
            return true;
        return false;
    }


}
