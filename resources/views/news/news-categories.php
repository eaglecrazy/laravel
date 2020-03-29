<div>
    <h2>Разделы</h2>
    <?php foreach ($categories as $item): ?>
        <a href="<?= route('news.category', $item['link'])?>"><?= $item['name'] ?></a><br>
    <?php endforeach; ?>
</div>
<hr>

