<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список районів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-index">

    <h1><img src="/images/admin/address-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>



    <p>
        <?= Html::a('Додати район', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Відображаються позиції {begin, number}-{end, number} із {totalCount, number}",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [   'attribute'=>'area_id',
                'contentOptions' =>['style'=>'text-align:center'],
                'headerOptions' => ['style' => 'text-align:center'],
                'label'=>'ID',
                'options' => ['width' => '70']
            ],
            [   'attribute'=>'name',
                'label'=>'Назва району',
                'options' => ['width' => '350']
            ],
            [   'attribute'=>'region_id',
                'label'=>'Область / ID області',
                'options' => ['width' => '350'],
                'format'=>'html', // Возможные варианты: raw, html
                'content'=>function($data){
                    return !empty($data->region->name_region)?
                        $data->region->name_region  .' / ID: '.$data->region_id :
                        '<span style="color: #de0810">Область не задана</span>';
                },
            ],

            [   'class' => 'yii\grid\ActionColumn',
                'header'=>'Дії',
                'headerOptions' => ['width' => '80','style' => 'text-align:center;color:#337ab7;'],
                'contentOptions' =>['style'=>'text-align:center'],
                'template' => '{view} {update} {delete}{link}',

            ],
        ],
    ]); ?>
</div>
