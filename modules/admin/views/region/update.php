<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Region */

$this->title = 'Обновити:'.$model->name_region;
$this->params['breadcrumbs'][] = ['label' => 'Список областей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_region, 'url' => ['view', 'id' => $model->region_id]];
$this->params['breadcrumbs'][] = 'Відредагувати';
?>
<div class="region-update">

    <h1><img src="/images/admin/address-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>