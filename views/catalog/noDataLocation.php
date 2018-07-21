<?php

$name_area = (!empty($area_id)) ? $result[0]['name'] : '';

$this->title = 'Перелік підприємств - ' . $result[0]['region']['name_region'] . ' - ' . $name_area . ' всі види діяльності  - Каталог Панорама';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Діючі підприємства, установи, організації, компанії, фірми всіх форм власності
    ' . $result[0]['region']['name_region'] . ' - ' . $name_area . ' з повною інформацією про діяльність']);

?>

<div class="site-error">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            Дані відсутні. Виберіть інший район/область або <a href="/add">додайте</a> Ваше підприємство першими!
        </div>
    </div>
</div>