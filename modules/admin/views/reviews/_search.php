<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\ReviewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'reviews_id') ?>

    <?= $form->field($model, 'name_user') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'date_publication') ?>

    <?= $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'news_id') ?>

    <?php // echo $form->field($model, 'access') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
