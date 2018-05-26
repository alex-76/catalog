<?php


use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


use app\assets\AdminAsset;

AdminAsset::register($this);

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
<?php $this->beginBody() ?>

<div class="wrap">

<?php
NavBar::begin([
    'brandLabel' => 'Панель управління',
    'brandUrl' => '/admin/default/',
    'options' => [
        'class' => 'navbar-inverse',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [        
        ['label' => 'Клієнти', 'url' => ['#'],
            'items' => [
                ['label' => 'Додати клієнта', 'url' => ['/admin/post/create']],
                ['label' => 'Список клієнтів', 'url' => ['/admin/post/index']],
            ],
        ],
        ['label' => 'Регіон', 'url' => ['#'],
            'items' => [
                ['label' => 'Область', 'url' => ['/admin/region/index']],
                ['label' => 'Район', 'url' => ['/admin/area/index']],
            ],
        ],
        ['label' => 'Каталог', 'url' => ['#'],
            'items' => [
                ['label' => 'Рубрика', 'url' => ['/admin/category/index']],
                ['label' => 'Підрубрика', 'url' => ['/admin/subcategory/index']],
            ],
        ],
        ['label' => 'Банера', 'url' => ['#'],
            'items' => [
                ['label' => 'Додати банер', 'url' => ['/admin/banner/create']],
                ['label' => 'Список банерів', 'url' => ['/admin/banner/index']],
            ],
        ],
        ['label' => 'Новини', 'url' => ['#'],
            'items' => [
                ['label' => 'Додати новини', 'url' => ['/admin/news/create']],
                ['label' => 'Список новин', 'url' => ['/admin/news/index']],
            ],
        ],
        ['label' => 'Відгуки', 'url' => ['#'],
            'items' => [
                ['label' => 'Додати відгук', 'url' => ['/admin/reviews/create']],
                ['label' => 'Список відгуків', 'url' => ['/admin/reviews/index']],
            ],
        ],
        ['label' => 'Підписка', 'url' => ['#'],
            'items' => [
                ['label' => 'Список підписчиків', 'url' => ['/admin/subscription/index']],
            ],
        ],
        ['label' => 'Безпека', 'url' => ['#'],
            'items' => [
                ['label' => 'Користувачі', 'url' => ['/admin/user/index']],
            ],
        ],
        Yii::$app->user->isGuest ? (
        ['label' => 'Вхід', 'url' => ['/catalog/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/catalog/logout'], 'post',['style'=>'margin-top: 7px'])
            . Html::submitButton(
                'Вихід (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        )
    ],
]);
NavBar::end();
?>


<div class="container">

    <div class="row">

        <div class="col-md-12">

            <?= $content; ?>

        </div>
    </div>
</div>

</div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Панорама Полтавщини <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
