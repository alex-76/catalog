<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список клієнтів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><img src="/images/admin/pixam-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Додати клієнта', ['create'], ['class' => 'btn btn-success']) ?>
    </p>







    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "
              <span class=\"label label-info\"><a style=\"color:#fff;\" href=\"/admin/post/index\">Всі</a></span>
              <span class=\"label label-success\"><a style=\"color:#fff;\" href=\"/admin/post/index?filter=success\">Активні</a></span>
              <span class=\"label label-warning\"><a style=\"color:#fff;\" href=\"/admin/post/index?filter=warning\">Закінчується</a></span>
              <span class=\"label label-danger\"><a style=\"color:#fff;\" href=\"/admin/post/index?filter=danger\">Прострочені</a></span>                    
              <b style='float: right;'>Відображаються позиції {begin, number}-{end, number} із {totalCount, number}</b><br><br>",
        'emptyText' =>'Дані відсутні',
        'showHeader' => true,
        //'layout'=>"{sorter}\n{pager}\n{summary}\n{items}",
        'layout'=>"{summary}\n{items}\n{pager}",

        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [   'attribute'=>'post_id',
                'label'=>'ID',
                'options' => ['width' => '70'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;'],
            ],
            [
                'attribute'=>'name_company',
                'label'=>'Назва компанії',
                'options' => ['width' => '300'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;'],
                'contentOptions' =>['style'=>'vertical-align:middle;font-size:13px;'],

            ],
            [
                'attribute'=>'region',
                'filter' => false, //+
                'label'=>'Область / район',
                'options' => ['width' => ''],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;color:#337ab7;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;font-size:13px;'],
                'value' => function($data){
                    //return $data['category']['name'];
                    return $data['region']['name_region'] .' / '. $data['area']['name'];
                }

            ],

            [
                'attribute'=>'category',
                'filter' => false,//+
                'label'=>'Рубрика / підрубрика',
                'options' => ['width' => ''],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;color:#337ab7;'],
                'contentOptions' =>['style'=>'text-align:center;vertical-align:middle;font-size:13px;'],
                'value' => function($data){
                    //return $data['category']['name'];
                    return $data['category']['name'] .' / '. $data['subcategory']['title'];
                }

            ],



            [
                'attribute'=>'date_publication',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;font-size:16px;vertical-align:middle;'],
                'label'=>'Дата початку публікації',
                'format' => 'raw',
                'options' => ['width' => '130'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle'],
                'value' => function($data){
                    return '<span class="label label-success">'.date("d.m.Y, H:i",strtotime($data->date_publication)).'</span>';

                },

            ],
            [
                'attribute'=>'payments',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center;font-size:16px;'],
                'label'=>'Дата закінчення публікації',
                //'format' => ['datetime', 'php:d.m.Y / h:i:s'],
                'format' => 'raw',
                'options' => ['width' => '180'],
                'headerOptions' => ['style' => 'text-align:center;vertical-align:middle;color:#337ab7;'],
                'value' =>  function($data){

                $arr = \app\modules\admin\controllers\PostController::Parsetimestamp(strtotime($data['payments']['enddate']) - time());

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
                      date("d.m.Y, H:i",strtotime($data['payments']['enddate'])).'</span><br>
                      <small style="font-size: 11px;"> '.
                      $arr['month'].' міс.'.
                      $arr['day']  .' днів.'.
                      $arr['hour'] .' год.'.
                      $arr['min']  .' хв.'.
                      //$arr['sec']  .' сек.'.
                      '</small>';
                },

            ],

            [
                'attribute'=>'access',
                'filter' => false,
                'contentOptions' =>['style'=>'text-align:center'],
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
                'headerOptions' => ['width' => '','style' => 'text-align:center;color:#337ab7;vertical-align:middle'],
                'contentOptions' =>['style'=>'text-align:center;'],
                'template' => '{view} {update} {delete} &nbsp;{link}',
                'buttons' => [
                    'link' => function ($url,$model) {
                        return Html::a(' <span class="glyphicon glyphicon-calendar"></span>',
                            '/admin/payments/update?id='.$model['payments']['pay_id'],['title'=>'Продовжити термін публікації']);
                    },

                ],

            ],

        ],
    ]); ?>
</div>

