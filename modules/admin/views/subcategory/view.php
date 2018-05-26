<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Subcategory */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Підрубрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subcategory-view">

    <h1><img src="/images/admin/catalog-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Обновити', ['update', 'id' => $model->subcategory_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->subcategory_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'subcategory_id',
            'title',
            [
                'attribute' => 'category_id',
                'label'=>'Назва рубрики',
                'format' => 'raw',
                'value' => function($data){
                    return !empty($data->category->name)?
                        $data->category->name :
                        '<span style="color: #de0810">Область не задана</span>';
                }
            ],

        ],
    ]) ?>

</div>