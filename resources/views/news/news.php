<?php

//include_once '../menu.php';
//Почему предыдущая строка вызывает ошибку? И как сделать чтобы работало?
//echo __DIR__; выводит: /home/vagrant/code/laravel/resources/views/news
//ОШИБКА: include_once(../menu.php): failed to open stream: No such file or directory


//Сделал пока абсолютный путь.
include_once '/home/vagrant/code/laravel/resources/views/menu.php';
include_once 'news-categories.php';
?>


<?php if ($categoryName !== null):?>
    <h1>Новости раздела <?= $categoryName ?></h1>
<?php else:?>
    <h1>Новости</h1>
<?php endif;?>


<div>
    <?php foreach ($news as $id => $item): ?>
        <a href="<?= route('news.item', [App\Category::getCategoryLink($item['category']), $id]) ?>">
            <?= $item['title'] ?>
        </a>
        <br>
    <?php endforeach; ?>
</div>



