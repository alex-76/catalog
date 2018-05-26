<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->params['breadcrumbs'][] = 'Додати публікацію';

$this->title = 'Додати підприємство, товари та послуги у каталог України';

$this->registerCssFile('@web/css/add.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);

?>


<?php if(Yii::$app->session->hasFlash('success-ok')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('success-ok'); ?>
    </div>


<?php elseif(Yii::$app->session->hasFlash('error-ok')):?>
    <div class="alert alert-success">
        <?php echo Yii::$app->session->getFlash('error-ok'); ?>
    </div>


<?php else: ?>

<h1>ДОДАТИ ПІДПРИЄМСТВО В КАТАЛОГ</h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>



<?php $form = ActiveForm::begin([
    'id' => 'active-form',
    'options' => [
        'enctype' => 'multipart/form-data'
    ],
]) ?>
<?= $form->field($form_model, 'name_company')->textInput(['placeholder' => "Назва компанії"])->label(''); ?>
<?= $form->field($form_model, 'name_client')->textInput(['placeholder' => "Контактна особа"])->label(''); ?>
<?= $form->field($form_model, 'address')->textInput(['placeholder' => "Адреса компанії"])->label(''); ?>
<?= $form->field($form_model, 'email')->textInput(['placeholder' => "Ваш Email"])->label(''); ?>
<?= $form->field($form_model, 'phone')->textInput(['placeholder' => "Ваш телефон"])->label(''); ?>
<?= $form->field($form_model, 'url_site')->textInput(['placeholder' => "Адреса сайта"])->label(''); ?>


<?php
    $region = \app\models\Region::find()->all();
    $items = yii\helpers\ArrayHelper::map($region,'region_id','name_region');
    $params = [
        'prompt' => 'Виберіть область...'
    ];
    echo $form->field($form_model, 'region_id')->dropDownList($items,$params)->label(''); ?>

<?php
    $params = [
        'prompt' => 'Виберіть район...'
    ];
    echo $form->field($form_model, 'area_id')->dropDownList([],$params)->label(''); ?>

<?php
    $category = \app\models\Category::find()->all();
    $items = yii\helpers\ArrayHelper::map($category,'category_id','name');
    $params = [
        'prompt' => 'Виберіть рубрику...'
    ];
    echo $form->field($form_model, 'category_id')->dropDownList($items,$params)->label(''); ?>

<?php
    $params = [
        'prompt' => 'Виберіть підрубрику...'
    ];
    echo $form->field($form_model, 'subcategory_id')->dropDownList([],$params)->label(''); ?>

<?= $form->field($form_model, 'description')->textarea(['rows' => '3', 'placeholder' => "Опис діяльності"])->label(''); ?>
<?= $form->field($form_model, 'plan')->radioList(array('0' => 'Стандарт',1 => 'Преміум'),['value'=>0,'id'=>'plan']); ?>
<div id="panel-upload" style="display: none;">
    <?= $form->field($form_model, 'gallery[]')->fileInput(['multiple' => true]) ?>
</div>


<?= $form->field($form_model, 'image')->fileInput() ?>


<?= Html::submitButton('Відправити', ['class' => 'btn btn-lg']) ?>
<?php ActiveForm::end() ?>

<?php endif; ?>





<?php
$js = <<<JS
$("#post-region_id").change(function () {     
    
     $.ajax({
         url: '/ajax/area',
         type: 'POST',
         'cache':false,
         data: {region_id:$("#post-region_id").val(),act:'area'},
         success: function(res){
            $('#post-area_id').html(res.result); 
         },
         error: function(res){
             console.log(res);
         }
     });         
});
$("#post-category_id").change(function () {    
    
         $.ajax({
         url: '/ajax/subcategory',
         type: 'POST',
         'cache':false,
         data: {category_id:$("#post-category_id").val(),act:'subcategory'},
         success: function(res){
            $('#post-subcategory_id').html(res.result); 
         },
         error: function(res){
             console.log(res);
         }
     })    
    
});
$(':radio').click(function(){    
    $('#panel-upload').toggle(300);    
});

JS;
$this->registerJs($js);
?>







