<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Subscription */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Підписчики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-view">

    <h1><img src="/images/admin/subscription-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Змінити', ['update', 'id' => $model->sub_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->sub_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочите видалити цей елемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sub_id',
            'email:email',
            [
                'attribute'=>'date',
                'label'=>'Дата підписки',
                //'format' => ['datetime', 'php:d M Y / h:i:s'],
                'options' => ['width' => '200'],
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';
                    return Yii::$app->formatter->asDatetime($data->date, "php:d.m.Y H:i");
                }

            ],
        ],
    ]) ?>

</div>
