<?php

use yii\helpers\Html;
$this->title = 'Адмінка';

//$this->registerCssFile('@app/modules/admin/css/test.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);

?>

<div class="row">
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/pixam-icon.jpg" width="150">
            <div class="caption">
                <h3>Клієнти</h3>
                <p>Список підприємств.</p>
                <p><a href="/admin/post/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/address-icon.png" width="150">
            <div class="caption">
                <h3>Регіон</h3>
                <p>Список областей та районів</p>
                <p><a href="/admin/region/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/catalog-icon.png" width="150">
            <div class="caption">
                <h3>Каталог</h3>
                <p>Список рубрик та підрубрик</p>
                <p><a href="/admin/category/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/security-icon.png" width="150">
            <div class="caption">
                <h3>Безпека</h3>
                <p>Особиста інформація</p>
                <p><a href="/admin/user/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/banner-icon.jpg">
            <div class="caption">
                <h3>Банера</h3>
                <p>Список банерів</p>
                <p><a href="/admin/banner/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/news-icon.png" width="185">
            <div class="caption">
                <h3>Новини</h3>
                <p>Список останніх новин</p>
                <p><a href="/admin/news/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/reviews-icon.png" width="185">
            <div class="caption">
                <h3>Відгуки</h3>
                <p>Список останніх відгуків</p>
                <p><a href="/admin/reviews/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="/images/admin/subscription-icon.jpg" width="175">
            <div class="caption">
                <h3>Підписка</h3>
                <p>Управління підпискою</p>
                <p><a href="/admin/subscription/index" class="btn btn-primary" role="button">Перейти...</a></p>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

