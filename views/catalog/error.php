<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

           $message = '';
           $title = '';
           //Yii::$app->response->statusCode = 500;
            switch (Yii::$app->response->statusCode) {
                case '404': $title = 'Сторінка не знайдена'; $message = '<img src="/images/404.png" class="img-responsive">'; break;
                case '403': $title = 'Доступ заборонений';   $message = '<img src="/images/403.png" class="img-responsive">'; break;
                case '500': $title = 'Серверна помилка';   $message = '<img src="/images/500.png" class="img-responsive">'; break;

            }

$this->params['breadcrumbs'][] = $title;
$this->title = $title;

?>
<div class="site-error">
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <?=$message ?>
        <?/*= nl2br(Html::encode($message)) */?>
       </div>
    </div>

</div>
