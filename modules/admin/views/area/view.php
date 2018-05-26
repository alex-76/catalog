<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Area */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список районів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-view">

    <h1><img src="/images/admin/address-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Змінити', ['update', 'id' => $model->area_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->area_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочите видалити цей район?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'area_id',
                'label'=>'ID',
            ],
            [
                'attribute' => 'name',
                'label'=>'Район',
            ],
            [
                'attribute' => 'region_id',
                'label'=>'Область',
                'format' => 'raw',
                'value' => function($data){
                    return !empty($data->region->name_region)?
                         $data->region->name_region :
                        '<span style="color: #de0810">Область не задана</span>';
                }
            ],
        ],
    ]) ?>

</div>