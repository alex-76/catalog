<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\SubscriptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Підписка на новини';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-index">

    <h1><img src="/images/admin/subscription-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p id="block-btn">
        <button type="button" id="sub_send" class ='btn btn-success'>
            Розіслати <span class="glyphicon glyphicon-send"></span>
        </button>
        <img src="/images/load.gif" style="display:none" id="load">
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' =>'Дані відсутні',
        'showHeader' => true,
        'summary' => "<b style='float: right;'>Відображаються позиції {begin, number}-{end, number} із {totalCount, number}</b><br><br>",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [   'attribute'=>'sub_id',
                'label'=>'ID',
                'options' => ['width' => '70'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [
                'attribute'=>'email',
                'label'=>'Email підписчика',
                //'filter' => false,
                'options' => ['width' => '400'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'vertical-align:middle;font-size:13px;'],

            ],
            [
                'attribute'=>'date',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;font-size:16px;vertical-align:middle;'],
                'label'=>'Дата підписки',
                'format' => 'raw',
                'options' => ['width' => '230'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle'],
                'value' => function($data){
                    return '<span class="label label-success">'.date("d.m.Y, H:i",strtotime($data->date)).'</span>';

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
