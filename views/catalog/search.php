<?php

    use yii\widgets\LinkPager;
    use yii\widgets\Breadcrumbs;
    use yii\helpers\Html;

    $this->params['breadcrumbs'][] = 'Результати пошуку';
    $this->title = 'Пошук публікацій';

    $this->registerCssFile('@web/css/search.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
?>

<?php if(Yii::$app->session->hasFlash('no-query')):?>
    <div class="alert alert-success">
        <span class="glyphicon glyphicon-hand-up"></span> <?php echo Yii::$app->session->getFlash('no-query'); ?>
    </div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('no-result')):?>
    <div class="alert alert-success">
        <span class="glyphicon glyphicon-hand-up"></span> <?php echo Yii::$app->session->getFlash('no-result'); ?>
    </div>
<?php endif; ?>

    <?php if($count!=0):?>
    <div class="header-h3">Результати пошуку (<?=$count; ?>): <b><?=!empty($q)?'&quot;'.$q.'&quot;':''; ?></b></div>
    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?php endif; ?>

<?php if(!empty($result)): ?>

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
                        <a target="_blank" class="link-subcat"
                           href="/show/<?= $val->post_id; ?>/<?= Yii::$app->translit->translit($val->name_company); ?>">
                            <?=preg_replace('~' . preg_quote($q) . '~iu', '<span style="color:#de0810">$0</span>', $val->name_company); ?>
                        </a>
                    </div>
                    <small class="data-publication"><?= date('d.m.Y',strtotime($val->date_publication)); ?> | <?=$result[0]->category->name ?> | <?=$result[0]->subcategory->title  ?></small>
                    <div class="discription" style="font-style: normal">
                        <?=preg_replace('~' . preg_quote($q) . '~iu', '<span style="color:#de0810">$0</span>', \yii\helpers\StringHelper::truncate(mb_substr($val->description, mb_strpos($val->description, $q)),130,'...')); ?>
                    </div>

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

<?php endif; ?>








