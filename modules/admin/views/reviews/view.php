<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */

$this->title = 'Відгук від: '.$model->name_user;
$this->params['breadcrumbs'][] = ['label' => 'Відгуки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reviews-view">

    <h1><img src="/images/admin/reviews-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Обновити', ['update', 'id' => $model->reviews_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->reviews_id], [
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
            'reviews_id',
            'name_user',
            'email:email',
            [
                'attribute'=>'date_publication',
                'label'=>'Дата публікації',
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';
                    return Yii::$app->formatter->asDatetime($data->date_publication, "php:d.m.Y H:i");
                }
            ],
            'content:ntext',
            [
                'attribute'=>'news_id',
                'label'=>'Назва новин',
                'format' => 'raw',
                'value' => function($data){
                        $result = \app\models\News::find()->where(['news_id' => $data->news_id])->asArray()->all();
                        return $result[0]['name_news'];
                },
            ],
            [
                'attribute' => 'access',
                'label'=>'Статус',
                'format' => 'raw',
                'value' => function($data){
                    return ($data->access == 1)?
                        '<span style="color:#008000">Активовано</span>' :
                        '<span style="color:#de0810">Деактивовано</span>';
                }
            ],
        ],
    ]) ?>

</div>
