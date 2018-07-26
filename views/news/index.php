<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] =  'Новини';

$this->title = 'Останні економічні новини України -  Каталог Панорама';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Новини бізнесу. Свіжі новини компаній каталогу. Виставки, конференції України: прес релізи. 
    Розвиток ринку, фінанси України, економічний розвиток. Фінансовий аналіз.'
]);

$this->registerCssFile('@web/css/news.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);

?>

<?= Breadcrumbs::widget([
    'homeLink' => ['label' => 'Головна', 'url' => '/'],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>


<?php foreach ($result as $val): ?>

    <div class="row">
        <div class="col-md-3">
            <img   alt="<?=$val->alt_image ?>" title="<?=$val->title_image ?>" src='<?=$val->getImage()->getUrl('180x') ?>'>
        </div>
        <div class="col-md-9">
            <div class="title-main">
                <a href="<?= Url::to(['news/' . $val->news_id . '/' . Yii::$app->translit->translit($val->meta_keyword)]) ?>"><?= $val->name_news; ?></a>
            </div>
            <p class="posted-on">
                <i>Автор</i> <?=$val->author ?>
                <i>дата</i> <?=date('d.m.Y',strtotime($val->date_news)) ?>
                | <span class="glyphicon glyphicon-thumbs-up"></span> (
                    <?php
                        $i = 0;
                        foreach ($val['reviews'] as $v) {
                              if($v['news_id'] == $val->news_id && $v['access'] == '1') {
                                  $i++;
                              }
                          }
                          echo $i;
                    ?>
                )
            </p>
            <p class="discription"><?= \yii\helpers\StringHelper::truncate(strip_tags($val->description),350,'...') ?></p>
        </div>

    </div>

<?php endforeach ?>

<div class="text-center">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'maxButtonCount' => 5,
        'linkOptions' => [
            'rel' => 'canonical'
        ],

    ]) ?>
</div>




