<?php

use kartik\datetime\DateTimePicker;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_client')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_site')->textInput(['maxlength' => true]) ?>


    <?php

    /*echo $form->field($model, 'description')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'standard', //разработанны стандартные настройки basic, standard, full
            'inline' => false,  //по умолчанию false
        ],
    ]);*/


    echo $form->field($model, 'description')->textarea(array('rows'=>10,'cols'=>5));


    ?>

    <?php
    foreach ($modelCategory as $val) {
        $arrCategory[$val['category_id']] =  $val['name'];
    }
    echo $form->field($model, 'category_id')->dropDownList($arrCategory,['id'=>'selectCategory']);
    ?>

    <?php
    foreach ($modelSubcategory as $val) {
        $arrSubcategory[$val['subcategory_id']] =  $val['title'];
    }
    echo $form->field($model, 'subcategory_id')->dropDownList($arrSubcategory,['id' => 'listSubcategory']);
    ?>

    <?php
    foreach ($modelRegion as $val) {
        $arrRegion[$val['region_id']] =  $val['name_region'];
    }
    echo $form->field($model, 'region_id')->dropDownList($arrRegion,['id' => 'selectRegion']);
    ?>

    <?php
    foreach ($modelArea as $val) {
        $arrArea[$val['area_id']] =  $val['name'];
    }
    echo $form->field($model, 'area_id')->dropDownList($arrArea,['id' => 'listArea']);
    ?>

    <?= $form->field($model, 'plan')->dropDownList([ 'Стандарт', 'Преміум', ], ['prompt' => 'Виберіть тарифний план...']) ?>



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
    ]); ?>


    <?php

    echo $form->field($modelPayments, 'enddate')->widget(DateTimePicker::className(),[
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




    <!-- Show blocl only for post/update -->
    <?php if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == 'post/update'): ?>

    <div class="form-group">
        <h4><b>Прикріплені файли:</b></h4>
        <?php
        echo (!empty($model->getImage()->id))?
            "<img src='". $model->getImage()->getUrl('100x')."'> ".
            \yii\helpers\Html::a('<span class="glyphicon glyphicon-remove"></span> ',
            ['/admin/post/deletemoreimg', 'post_id' => $model->post_id, 'id'=> $model->getImage()->id],
            ['class' => 'btn_port_del','title' => 'Видалити логотип']): '';


        foreach ($model->getImages() as $img) {

            if($img['isMain']!= 1 && !empty($img->itemId))
            {
                if($img->extension == 'jpg' || $img->extension == 'png' || $img->extension == 'gif') {
                    echo Html::img($img->getUrl(),['class'=>'img_attachment','style'=>'width:85px']);
                    // Блок для удаления выбранного изображения
                    echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-remove"></span> ',
                        ['/admin/post/deletemoreimg', 'post_id' => $img->itemId, 'id'=> $img->id],
                        ['class' => 'btn_port_del','title' => 'Видалити '.$img->name]);
                }
                else {
                    echo  Html::a($img->name.'.'.$img->extension, '/images/store/'.$img->filePath). ' ';
                    echo \yii\helpers\Html::a('<span class="glyphicon glyphicon-remove"></span> ',
                        ['/admin/post/deletemoreimg', 'post_id' => $img->itemId, 'id'=> $img->id],
                        ['class' => 'btn_port_del','title' => 'Видалити '.$img->name]);
                }
            }
        }

        $query_items_all = Yii::$app->db->createCommand('SELECT * FROM image WHERE itemId = '.$model->post_id.'')->queryAll();
        $query_main = Yii::$app->db->createCommand('SELECT * FROM image WHERE itemId = '.$model->post_id.' AND isMain = 1')->queryOne();
        $query_items = Yii::$app->db->createCommand('SELECT * FROM image WHERE itemId = '.$model->post_id.' AND isMain IS NULL')->queryAll();


        if($query_main == false) {
            echo '<hr>';
            echo $form->field($model, 'image')->fileInput();
        }

        if(count($query_items)==0) {
            echo $form->field($model, 'gallery[]')->fileInput(['multiple' => true]);
        }

        if(count($query_items_all) > 0) {
            echo '<hr>';
            echo \yii\helpers\Html::a('<button type="button" class="btn btn-danger">Видалити всі зображення</button>', [
                '/admin/post/deletemoreimg',
                'post_id' => $model->getImages()[0]->itemId,
                'id'      => $model->getImages()[0]->id,
                'all_img' => 1
            ],
                ['class' => 'btn_port_del']);
        }

        ?>
    </div>

<?php endif; ?>

    <!-- Show block only for post/create -->
    <?php if(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id == 'post/create'): ?>
        <h4><b>Додати файли:</b></h4>
        <?php

            echo $form->field($model, 'image')->fileInput();
            echo $form->field($model, 'gallery[]')->fileInput(['multiple' => true]);

        ?>


    <?php endif; ?>



    <?= $form->field($model, 'logo_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access')->dropDownList([ 'Деактивувати', 'Активувати', ], ['prompt' => 'Виберіть статус...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
$("#selectCategory").change(function () {     
    
     $.ajax({
         url: '/ajax/subcategory',
         type: 'POST',
         'cache':false,
         data: {category_id:$("#selectCategory").val(),act:'subcategory'},
         success: function(res){
            $('#listSubcategory').html(res.result); 
         },
         error: function(res){
             console.log(res);
         }
     });         
});

$("#selectRegion").change(function () {     
    
     $.ajax({
         url: '/ajax/area',
         type: 'POST',
         'cache':false,
         data: {region_id:$("#selectRegion").val(),act:'area'},
         success: function(res){
            $('#listArea').html(res.result); 
         },
         error: function(res){
             console.log(res);
         }
     });         
});


JS;
$this->registerJs($js);
?>


