<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\ReviewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Відгуки по новинам';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reviews-index">

    <h1><img src="/images/admin/reviews-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Додати відгук', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' =>'Дані відсутні',
        'showHeader' => true,
        'summary' => "<b style='float: right;'>Відображаються позиції {begin, number}-{end, number} із {totalCount, number}</b><br><br>",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [   'attribute'=>'reviews_id',
                'label'=>'ID',
                'options' => ['width' => '70'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [   'attribute'=>'name_user',
                'label'=>'Імя',
                'options' => ['width' => '150'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [   'attribute'=>'email',
                'label'=>'Email',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [
                'attribute'=>'news_id',
                'label'=>'Назва новин',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'options' => ['width' => '200'],
                'format' => 'raw',
                'value' => function($data){
                    $result = \app\models\News::find()->where(['news_id' => $data->news_id])->asArray()->all();
                    return (!empty($result[0]['name_news'])) ? $result[0]['name_news'] : '<span style="color:#d21717">Стаття видалена</span>';
                },
            ],
            [
                'attribute'=>'date_publication',
                'filter' => false,
                'label'=>'Дата публікації',
                'options' => ['width' => '130'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'format' => 'html',
                'value' => function($data){
                    return '<span class="label label-success">'.date("d.m.Y, H:i",strtotime($data->date_publication)).'</span>';
                }
            ],
            [
                'attribute'=>'content',
                'filter' => false,
                'label'=>'Відгук',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'vertical-align:middle;'],
                'format' => 'html',
                'value' => function($data){
                    return \yii\helpers\StringHelper::truncate(strip_tags($data->content),150,'...');
                }

            ],
            [
                'attribute'=>'access',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'label'=>'Статус',
                'options' => ['width' => '60'],
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle'],
                'value' => function($data){
                    return !empty($data->access)?
                        '<span class="label label-success">Yes</span>' :
                        '<span class="label label-danger">No</span>';
                },

            ],

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'Дії',
                'headerOptions' => ['width' => '70','style' => 'text-align:center;color:#337ab7;vertical-align:middle'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'template' => '{view} {update} {delete} &nbsp;{link}',


            ],
        ],
    ]); ?>
</div>
