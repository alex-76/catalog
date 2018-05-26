<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новини';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><img src="/images/admin/news-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>


    <p>
        <?= Html::a('Додати новини', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' =>'Дані відсутні',
        'showHeader' => true,
        'summary' => "<b style='float: right;'>Відображаються позиції {begin, number}-{end, number} із {totalCount, number}</b><br><br>",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [   'attribute'=>'news_id',
                'label'=>'ID',
                'options' => ['width' => '70'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [
                'attribute'=>'image',
                'label'=>'Фото',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'format' => 'html',
                'value' => function($data){
                    return '<img src="'.$data->getImage()->getUrl('100x').'">';
                }
            ],
            [
                'attribute'=>'name_news',
                'label'=>'Назва новин',
                'options' => ['width' => '200'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'vertical-align:middle;font-size:13px;'],

            ],
            [
                'attribute'=>'description',
                'label'=>'Опис',
                'options' => ['width' => '500'],
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'vertical-align:middle;font-size:13px;'],
                'value' => function($data){
                    return \yii\helpers\StringHelper::truncate(strip_tags($data->description),350,'...');
                }

            ],
            [
                'attribute'=>'date_news',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;font-size:16px;vertical-align:middle;'],
                'label'=>'Дата початку публікації',
                'format' => 'raw',
                'options' => ['width' => '130'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle'],
                'value' => function($data){
                    return '<span class="label label-success">'.date("d.m.Y, H:i",strtotime($data->date_news)).'</span>';

                },

            ],


            ['class' => 'yii\grid\ActionColumn',
                'header'=>'Дії',
                'headerOptions' => ['width' => '100','style' => 'text-align:center;color:#337ab7;vertical-align:middle'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'template' => '{view} {update} {delete} &nbsp;{link}',


            ],
        ],
    ]); ?>
</div>
