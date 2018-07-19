<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\BannerWidget;
use app\components\CompanyWidget;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-99339955-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-99339955-2');
</script>


<?php $this->beginBody() ?>

<div class="wrap">

<?php
NavBar::begin([
    'innerContainerOptions' => ['class' => 'container-fluid menu-top'],
    'brandLabel' => '<img src="/images/logo.png" alt="Logo"/>',
    'brandUrl' => 'javascript:(0)',//Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id != 'catalog/index')?
            ['label' => 'ГОЛОВНА', 'url' => ['/']]:'',
        (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id != 'catalog/about')?
            ['label' => 'ПРО НАС', 'url' => ['/about']]:
            '<li class="active"><span class="active-item">ПРО НАС</span></li>',
        (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id != 'news/index')?
            ['label' => 'НОВИНИ', 'url' => ['news/index']]:
            '<li class="active"><span class="active-item">НОВИНИ</span></li>',
        (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id != 'catalog/plan')?
            ['label' => 'ПОСЛУГИ', 'url' => ['/plan']] :
            '<li class="active"><span class="active-item">ПОСЛУГИ</span></li>',
        (Yii::$app->controller->id.'/'.Yii::$app->controller->action->id != 'catalog/contact')?
            ['label' => 'КОНТАКТИ', 'url' => ['/contact']]:
            '<li class="active"><span class="active-item">КОНТАКТИ</span></li>'
    ],
]);
NavBar::end();
?>


<div class="container-fluid">


    <?= Alert::widget() ?>

    <div class="row">
        <div class="col-md-9 lf-block">
            <div class="row">
                <div class="col-md-3">
                    <p><a href="/add" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> Додати компанію</a></p>
                </div>
                <div class="col-md-9">
                    <form class="well form-inline" id="form-search" action="<?=yii\helpers\Url::to(['catalog/search']) ?>" method="get">
                        <div class="row">
                            <div class="col-md-12" id="div-result-search">
                                <input type="text" name="keyword" id="searchMain" class="form-control field-search" placeholder="Пошук підприємств...">
                                <button type="submit" class="btn btn-default btn-md btn-search">
                                    <span class="glyphicon glyphicon-search"></span> Шукати</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $content; ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <?php echo BannerWidget::widget(); ?>
            <div class="header-h3"><span class="glyphicon glyphicon-pushpin"></span> Нові підприємства</div>
            <?php echo CompanyWidget::widget(); ?>
        </div>
    </div>

</div>

</div>


<footer class="footer">
    <div class="row row-footer">
        <div class="col-md-3 ft">
            <div class="header-h4">РОЗДІЛИ САЙТУ</div>
            <ul class="list-unstyled">
                <li><a href="/">Головна</a></li>
                <li><a href="/about">Про нас</a></li>
                <li><a href="/news/index">Новини</a></li>
                <li><a href="/plan">Послуги</a></li>
                <li><a href="/contact">Контакти</a></li>
            </ul>
        </div>
        <div class="col-md-3 ft">
            <div class="header-h4">РОЗМІЩЕННЯ ІНФОРМАЦІЇ</div>
            <ul class="list-unstyled">
                <li><a href="/add">Додати компанію</a></li>
                <li><a target="_blank" href="/files/ugoda.pdf">Угода користувача</a></li>
            </ul>
        </div>
        <div class="col-md-3 ft">
            <div class="header-h4">ТЕЛЕФОНИ ДЛЯ ДОВІДОК</div>
            <ul class="list-unstyled">
                <li>(0532) 69-02-69</li>
                <li>050-216-00-69</li>
                <li>099-021-03-59</li>
                <li>096-906-62-13</li>
                <li>Email: <a href="mailto:info.catalog.ua@gmail.com?subject=Message">info.catalog.ua@gmail.com</a></li>
            </ul>
        </div>
        <div class="col-md-3 ft">
            <div class="header-h4">ПІДПИСАТИСЯ НА НОВИНИ</div>
            <form class="form-horizontal">
                <div class="form-group ft-subscription">
                    <div class="col-sm-10">
                        <input type="email" class="form-control subscription" id="inputEmail3" placeholder="Email">
                        <small class="subscription-note"><span class="glyphicon glyphicon-ok"></span></small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <a href="javascript:(0)" id="btn-subscription" class="btn btn-default">Підписатися</a>
                    </div>
                </div>
            </form>
            <p class="footer-icons-social">
                <a href="https://www.facebook.com" target="_blank"><img src="/images/facebook.svg" class="img-responsive net-social" alt="fb"></a>
                <a href="https://twitter.com" target="_blank"><img src="/images/twitter.svg" class="img-responsive net-social" alt="twit"></a>
                <a href="https://www.youtube.com/" target="_blank"><img src="/images/youtube.svg" class="img-responsive net-social" alt="ytube"></a>
                <a href="https://plus.google.com" target="_blank"><img src="/images/gplus.png" class="img-responsive net-social" alt="g+"></a>

            </p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <p class="pull-left">&copy; Панорама Полтавщини <?= date('Y') ?></p>
            </div>
            <div class="col-md-6">
                <small class="pull-right">Передрук, копіювання інформації дозволяється за умови відкритого для пошукових
                    систем гіперпосилання</small>
            </div>
        </div>


    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
