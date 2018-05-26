<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\RegionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список областей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-index">

    <h1><img src="/images/admin/address-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>



    <p>
        <?= Html::a('Додати область', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "Відображаються позиції {begin, number}-{end, number} із {totalCount, number}",
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'], //колонка со счетчиком

            [   'attribute'=>'region_id',
                'contentOptions' =>['style'=>'text-align:center'],
                'headerOptions' => ['style' => 'text-align:center'],
                'label'=>'ID',
                'options' => ['width' => '70']
            ],
            [   'attribute'=>'name_region',
                'label'=>'Назва області',
                'options' => ['width' => '550']
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