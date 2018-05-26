<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список банерів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <h1><img src="/images/admin/banner-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Додати банер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' =>'Дані відсутні',
        'showHeader' => true,
        'summary' => "<b style='float: right;'>Відображаються позиції {begin, number}-{end, number} із {totalCount, number}</b><br><br>",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],


            [   'attribute'=>'banner_id',
                'label'=>'ID',
                'options' => ['width' => '70'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [
                'attribute'=>'image',
                'label'=>'фото',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'format' => 'html',
                'value' => function($data){
                    return '<img src="'.$data->getImage()->getUrl('100x').'">';
                }
            ],
            [
                'attribute'=>'name_company',
                'label'=>'Назва компанії',
                'options' => ['width' => '400'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'vertical-align:middle;font-size:13px;'],

            ],
            [
                'attribute'=>'date_begin',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;font-size:16px;vertical-align:middle;'],
                'label'=>'Дата початку публікації',
                'format' => 'raw',
                'options' => ['width' => '130'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle'],
                'value' => function($data){
                    return '<span class="label label-success">'.date("d.m.Y, H:i",strtotime($data->date_begin)).'</span>';

                },

            ],

            [
                'attribute'=>'date_end',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'label'=>'Дата закінчення публікації',
                //'format' => ['datetime', 'php:d.m.Y / h:i:s'],
                'format' => 'raw',
                'options' => ['width' => '180'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;color:#337ab7;'],
                'value' =>  function($data){

                    $arr = \app\modules\admin\controllers\PostController::Parsetimestamp(strtotime($data->date_end) - time());

                    if($arr['month']>=1 || $arr['day'] >= 14) {
                        $style = 'label-success';
                    } else if($arr['day'] > 0 && $arr['day'] < 14) {
                        $style = 'label-warning';
                    } else {
                        $style = 'label-danger';
                        $arr['month'] = 0;
                        $arr['day'] = 0;
                        $arr['hour'] = 0;
                        $arr['min'] = 0;
                        //$arr['sec'] = 0;
                    }

                    return '<span class="label '.$style.'">'.
                        date("d.m.Y, H:i",strtotime($data->date_end)).'</span><br>
                      <small style="font-size: 11px;"> '.
                        $arr['month'].' міс.'.
                        $arr['day']  .' днів.'.
                        $arr['hour'] .' год.'.
                        $arr['min']  .' хв.'.
                        //$arr['sec']  .' сек.'.
                        '</small>';
                },

            ],
            'url',
            [
                'attribute'=>'position',
                'filter' => false,
                'label'=>'Позиція',
                'format' => 'raw',
                'options' => ['width' => '100'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'value' =>  function($data){
                    return '<a href="/admin/banner/changeposition?n=up&pos='.$data->position.'&bid='.$data->banner_id.'" title="вверх"><span class="glyphicon glyphicon-arrow-up"></span></a>
                            <a href="/admin/banner/changeposition?n=down&pos='.$data->position.'&bid='.$data->banner_id.'" title="вниз"><span class="glyphicon glyphicon-arrow-down"></span></a>';
                }

            ],
            [
                'attribute'=>'position',
                'filter' => false,
                'label'=>'Позиція',
                'options' => ['width' => '100'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],

            ],


            [
                'attribute'=>'accsess',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
                'label'=>'Статус',
                'options' => ['width' => '60'],
                'format' => 'raw',
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle'],
                'value' => function($data){
                    return !empty($data->accsess)?
                        '<span class="label label-success">Yes</span>' :
                        '<span class="label label-danger">No</span>';
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
