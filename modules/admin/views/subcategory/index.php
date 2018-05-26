<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\SubcategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Підрубрики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategory-index">

    <h1><img src="/images/admin/catalog-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Створити підрубрику', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [   'attribute'=>'subcategory_id',
                'contentOptions' =>['style'=>'text-align:center'],
                'headerOptions' => ['style' => 'text-align:center'],
                'label'=>'ID',
                'options' => ['width' => '70']
            ],
            [   'attribute'=>'title',
                'label'=>'Назва підрубрики',
                'options' => ['width' => '350']
            ],

            [   'attribute'=>'category_id',
                'label'=>'Рубрика / ID області',
                'options' => ['width' => '350'],
                'format'=>'html', // Возможные варианты: raw, html
                'content'=>function($data){
                    return !empty($data->category->name)?
                        $data->category->name  .' / ID: '.$data->category_id :
                        '<span style="color: #de0810">Рубрика не задана</span>';
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