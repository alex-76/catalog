<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Контакти';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/contact.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
?>

<div class="site-contact">


    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Дякуэмо за ваше звернення. Ми звяжимося найближчим часом.
        </div>


    <?php else: ?>

        <div class="row">
            <div class="col-md-12">

                <?php $form = ActiveForm::begin([
                        'id' => 'contact-form',
                        'options' => ['class' => 'form-horizontal'],

                ]); ?>

                    <?= $form->field($model, 'name')->textInput(['placeholder' => "Імя"])->label(''); ?>

                    <?= $form->field($model, 'email')->textInput(['placeholder' => "Email"])->label(''); ?>

                    <?= $form->field($model, 'subject')->textInput(['placeholder' => "Тема повідомлення"])->label(''); ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => "Повідомлення"])->label(''); ?>

                <?= $form->field($model, 'verifyCode')->widget(
                    yii\captcha\Captcha::className(),
                    [
                        'captchaAction' => 'catalog/captcha',
                        'template' => '<div class="row">
                            <div class="col-md-6">{image}</div>
                            <div class="col-md-6">{input}</div>
                            </div>',


                    ]
                )->hint('Натисніть на картинку, щоб обновти.') ?>



                    <div class="form-group">
                        <?= Html::submitButton('Відправити', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
