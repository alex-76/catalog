<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\model\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рубрики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><img src="/images/admin/catalog-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?php if(Yii::$app->session->hasFlash('error')):?>
        <div class="alert alert-danger">
            <?php echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <p>
        <?= Html::a('Додати рубрику', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],


            [   'attribute'=>'category_id',
                'contentOptions' =>['style'=>'text-align:center'],
                'headerOptions' => ['style' => 'text-align:center'],
                'label'=>'ID',
                'options' => ['width' => '70']
            ],
            [   'attribute'=>'name',
                'label'=>'Назва рубрики',
                'format' => 'raw',
                'value' => function($data){
                    return $data->name.' <span class="badge">'.count($data['subcategories']).'</span>';
                }

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