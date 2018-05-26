<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Payments */

$this->title = 'Продовжити термін публікації:';
$this->params['breadcrumbs'][] = ['label' => 'Список публікацій', 'url' => ['post/index']];
$this->params['breadcrumbs'][] = 'Продовжити термін публікації';

?>
<div class="payments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>