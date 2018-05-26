<?php

/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

$this->title = 'Про нас';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <h1>Про нашу компанію</h1>

    <p>
        Навигационные панели являются адаптивными цель-компонентами, которые служат в качестве навигационных заголовков
        для приложений или сайтов. При просмотре на мобильных устройствах они сворачиваются (и могут переключаться),
        а при увеличении ширины смотрового окна принимают горизонтальную форму.
    </p>


</div>
