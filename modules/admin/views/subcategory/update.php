<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Subcategory */

$this->title = 'Обновити підрубрику: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Підрубрики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->subcategory_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subcategory-update">

    <h1><img src="/images/admin/catalog-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelCategory' => $modelCategory,
    ]) ?>

</div>