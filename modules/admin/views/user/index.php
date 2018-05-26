<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Користувачі';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "<b style='float: right;'>Відображаються позиції {begin, number}-{end, number} із {totalCount, number}</b>",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],


            [   'attribute'=>'id',
                'label'=>'ID',
                'options' => ['width' => '70'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            'username',
            /*[   'attribute'=>'password',
                'label'=>'Пароль',
                'filter' => false,
                'options' => ['width' => '150'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],*/



            ['class' => 'yii\grid\ActionColumn',
                'header'=>'Дії',
                'headerOptions' => ['width' => '','style' => 'text-align:center;color:#337ab7;vertical-align:middle'],
                'contentOptions' =>['style'=>'text-align:center;'],
                'template' => '{view} {update}',


            ],
        ],
    ]); ?>
</div>