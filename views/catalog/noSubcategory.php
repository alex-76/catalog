<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;


$this->title = 'Дані по рубриці ' . $result[0]->title . ' відсутні.';

?>
<div class="site-error">

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            Дані по рубриці <b><?= $result[0]->title; ?></b> відсутні. Виберіть іншу <a href="/">підкатегорію</a>.
        </div>
    </div>

</div>
