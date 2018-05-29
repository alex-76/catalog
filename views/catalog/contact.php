<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Наші Контакти - Каталог Панорама';
$this->params['breadcrumbs'][] = 'Контакти';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Наші контакти: все про бізнес каталог Панорама. Замовити розміщення на сайті, зареєструвати 
    підприємство онлайн. Телефонуйте'
]);


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

                <div class="header-h2">ТОВ "Панорама Полтавщини"</div>
                <p>Код ЄДРПОУ 40710843</p>
                <p>Р/Р 26009054629499 в ПАТ КБ «ПРИВАТБАНК»</p>
                <p>МФО 331401</p>
                <div class="header-h2">Директор - Зінаїда Дикань</div>
                <p>(0532) 69-02-69,</p>
                <p>050 216-00-69,</p>
                <p>098-709-89-01.</p>
                <div class="header-h2">Обслуговування клієнтів – Галина Гончарук</div>
                <p>(0532) 65-40-74,</p>
                <p>099 021-03-59,</p>
                <p>096 906-62-13.</p>
                <div class="header-h2">Бухгалтерія - Марина Сергєєва</div>
                <p>099-279-82-13,</p>
                <p>093-322-16-67.</p>
                <p>E-mail: info.catalog.ua@gmail.com</p>
                <div class="header-h2">Для листів:</div>
                <p>а/с 1943, м. Полтава-21, 36021.</p>
                <div class="header-h2">Написати листа</div>

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
