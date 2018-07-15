<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = 'Дані відсутні';
$this->title = 'Дані відсутні у даній підкатегорії';

?>
<div class="site-error">
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            Дані відсутні. Виберіть іншу <a href="/">підкатегорію</a>.
        </div>
    </div>

</div>
