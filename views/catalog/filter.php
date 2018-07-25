<?php

    use yii\widgets\LinkPager;
    use yii\widgets\Breadcrumbs;
    use yii\helpers\Html;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = ['label' => $result[0]->region->name_region];
$this->params['breadcrumbs'][] = $result[0]->area->name;
$this->title = 'Підприємства - ' . $result[0]->region->name_region . (($area_id) ? ' / ' . $result[0]->area->name : '') . ': всі сфери діяльності';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Всі підприємтсва, фірми, установи - ' . $result[0]->region->name_region . (($area_id) ? ' / ' . $result[0]->area->name : '') .
        ': контактні дані, місцезнаходження, зображення на карті, повний опис діяльності та докладний перелік послуг.']);

    $this->registerCssFile('@web/css/filter.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
?>

<h1>Підприємства: <b><?php echo $result[0]->region->name_region .
            (($area_id) ? ' / ' . $result[0]->area->name : ''); ?></b></h1>

<?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

<?php Pjax::begin([
    'enablePushState' => false, // to disable push state
    'enableReplaceState' => false // to disable replace state
]); ?>

<?php foreach ($result as $val): ?>

    <?php $class = ($val->plan == 1)? 'vip-style':'';  ?>
    <div class="row">
        <div class="col-md-12 <?= $class; ?> firm-list-item">
            <div class="row">
                <div class="col-md-2">
                    <?php
                    foreach ($val->getImages() as $img) {
                        if($img['isMain']== 1) {
                            echo Html::img($img->getUrl('80x'),[
                                    'class' => 'img_attachment foto_company',
                                    'alt'   => ''.$val->name_company.'',
                                    'title' => ''.$val->name_company.''
                            ]);
                            break;
                        }
                        else {
                            echo Html::img('/images/store/no.png',['class'=>'img_attachment','style' =>'width:80px']);
                            break;
                        }
                    }
                    ?>
                </div>
                <div class="col-md-10">
                    <div class="title-main">
                        <a class="link-subcat"
                           href="/show/<?= $val->post_id; ?>/<?= Yii::$app->translit->translit($val->name_company); ?>"> <?= $val->name_company; ?></a>
                    </div>
                    <small class="data-publication"><?= date('d.m.Y',strtotime($val->date_publication)); ?> | <?=$result[0]->category->name ?> | <?=$result[0]->subcategory->title  ?></small>
                    <div class="discription"><?= \yii\helpers\StringHelper::truncate($val->description,130,'...') ?></div>

                </div>
            </div>
        </div>
    </div>

<?php endforeach ?>

<div class="text-center">
    <?= LinkPager::widget([
        'pagination' => $pagination,
        'maxButtonCount' => 5,
        'linkOptions' => [
            'rel' => 'canonical',
        ],
    ]) ?>
</div>

<?php Pjax::end(); ?>




