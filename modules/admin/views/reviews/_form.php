<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reviews */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reviews-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php

    echo $form->field($model, 'date_publication')->widget(DateTimePicker::className(),[
        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
        'options' => ['placeholder' => 'Ввод даты/времени...'],
        'convertFormat' => true,
        'value'=> date("yyyy-M-d h:i:s"),
        //'pickerButton' => ['icon' => 'time'],
        'pluginOptions' => [
            'format' => 'yyyy-MM-dd h:i:s',
            'autoclose'=>true,
            //'weekStart'=>1, //неделя начинается с понедельника
            //'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
            'todayBtn'=>true, //снизу кнопка "сегодня"
        ]
    ]);
    ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'news_id')->textInput() ?>


    <?= $form->field($model, 'access')->dropDownList([ 'Деактивувати', 'Активувати', ], ['prompt' => 'Виберіть статус...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
