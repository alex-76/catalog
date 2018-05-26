<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Post */

$this->title = 'Відредагувати клієнта: '.$model->name_company;
$this->params['breadcrumbs'][] = ['label' => 'Список публікацій', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_company, 'url' => ['view', 'id' => $model->post_id]];
$this->params['breadcrumbs'][] = 'Змінити';
?>
<div class="post-update">

    <h1><img src="/images/admin/pixam-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelPayments' => $modelPayments,
        'modelCategory' => $modelCategory,
        'modelSubcategory' => $modelSubcategory,
        'modelRegion' => $modelRegion,
        'modelArea' => $modelArea,
    ]) ?>

</div>