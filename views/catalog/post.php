<?php

    use yii\widgets\LinkPager;
    use yii\widgets\Breadcrumbs;
    use yii\helpers\Html;


    $this->params['breadcrumbs'][] = ['label' => $result[0]->category->name, 'url' => '/'];
    $this->params['breadcrumbs'][] = $result[0]->subcategory->title;
$this->title = $result[0]->category->name . ' / ' . $result[0]->subcategory->title . ' - Каталог Панорама';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Перелік підприємств, компаній в сфері ' .
        $result[0]->category->name . ' / ' . $result[0]->subcategory->title . ': всі регіони, області та райони України']);

    $this->registerCssFile('@web/css/post.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
?>

<h1>Підприємства: <b><?= $result[0]->category->name . ' / ' . $result[0]->subcategory->title ?></b></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

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
                        <a class="link-subcat" href="/show/<?=$val->post_id; ?>"> <?= $val->name_company; ?></a>
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









