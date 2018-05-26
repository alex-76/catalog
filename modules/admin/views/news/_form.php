<?php

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title_news')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_news')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[
                'preset' => 'full',
                'inline' => false,
                'height' =>600,
                'allowedContent' => true,

        ]),
    ]);?>

    <?= $form->field($model, 'meta_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alt_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <!-- Show blocl only for banner/update -->
    <?php if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == 'news/update'): ?>

        <div class="form-group">
            <?php
            echo (!empty($model->getImage()->id))?
                "<img src='". $model->getImage()->getUrl('100x')."'> ".
                \yii\helpers\Html::a('<span class="glyphicon glyphicon-remove"></span> ',
                    ['/admin/news/deletemoreimg', 'news_id' => $model->news_id, 'id'=> $model->getImage()->id],
                    ['class' => 'btn_port_del','title' => 'Видалити фото']): '';

            $query_main = Yii::$app->db->createCommand('SELECT * FROM image WHERE itemId = '.$model->news_id.' AND isMain = 1')->queryOne();
            if($query_main == false) {
                echo $form->field($model, 'image')->fileInput();
            }

            ?>


        </div>
    <?php endif; ?>

    <!-- Show block only for banner/create -->
    <?php if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == 'news/create'): ?>

        <?php
        echo $form->field($model, 'image')->fileInput();
        ?>

    <?php endif; ?>

    <?php

    echo $form->field($model, 'date_news')->widget(DateTimePicker::className(),[
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

    <?= $form->field($model, 'access')->dropDownList([ 'Деактивувати', 'Активувати', ], ['prompt' => 'Виберіть статус...']) ?>


    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
