<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_company')->textInput(['maxlength' => true]) ?>

    <?php

    echo $form->field($model, 'date_begin')->widget(DateTimePicker::className(),[
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

    echo $form->field($model, 'date_end')->widget(DateTimePicker::className(),[
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
    ]); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'attributes')->textInput(['maxlength' => true]) ?>

    <!-- Show blocl only for banner/update -->
    <?php if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == 'banner/update'): ?>

        <?= $form->field($model, 'position')->textInput() ?>

        <div class="form-group">
        <?php
        echo (!empty($model->getImage()->id))?
            "<img src='". $model->getImage()->getUrl('100x')."'> ".
            \yii\helpers\Html::a('<span class="glyphicon glyphicon-remove"></span> ',
                ['/admin/banner/deletemoreimg', 'banner_id' => $model->banner_id, 'id'=> $model->getImage()->id],
                ['class' => 'btn_port_del','title' => 'Видалити банер']): '';

        $query_main = Yii::$app->db->createCommand('SELECT * FROM image WHERE itemId = '.$model->banner_id.' AND isMain = 1')->queryOne();
        if($query_main == false) {
            echo $form->field($model, 'image')->fileInput();
        }

        ?>


    </div>
    <?php endif; ?>

    <!-- Show block only for banner/create -->
    <?php if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == 'banner/create'): ?>

        <?php
             echo $form->field($model, 'image')->fileInput();
        ?>

    <?php endif; ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'accsess')->dropDownList([ 'Деактивувати', 'Активувати', ], ['prompt' => 'Виберіть статус...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
