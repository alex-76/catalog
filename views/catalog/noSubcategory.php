<?php

$this->title = 'Підприємтсва України в рубриці ' . $result[0]->title . ' - Каталог Панорама';
$this->registerMetaTag([
    'name' => 'description',
    'content' => $result[0]->title . ': сервісне обслуговування,  опис послуг, графік роботи, контактна інформація, 
    місцезнаходження, прайс-лист, порівняти ціни.']);

?>
<div class="site-error">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            Дані відсутні. Виберіть іншу підкатегорію або <a href="/add">додайте</a> Ваше підприємство першими!
        </div>
    </div>
</div>
