<span>Меню пользователя: </span><br>

<!--На курсе HTML учили, что ссылку на текущую страницу нужно делать такую '#'.
Есть ли инструмент для этого?-->
<a href="<?=route('Home', null, false)?>">Главная</a><br>
<a href="<?=route('news.all', null, false)?>">Новости</a><br>
<a href="<?=route('admin.index', null, false)?>">Админка</a>
<hr>
