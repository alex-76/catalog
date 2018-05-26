<?php

use yii\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => $result[0]->category->name, 'url' => '/'];
$this->params['breadcrumbs'][] = ['label' => $result[0]->subcategory->title, 'url'=> '/post/'.$result[0]->subcategory->subcategory_id];
$this->params['breadcrumbs'][] = \yii\helpers\StringHelper::truncate($result[0]->name_company,30,'...');
$this->title = $result[0]->logo_name;

$this->registerCssFile('@web/css/show.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $result[0]->keywords]);
$this->registerMetaTag(['name' => 'description', 'content' => $result[0]->meta_description]);

?>



    <h1><?= $result[0]->name_company ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?php if($result[0]->plan == 0): ?>

        <?= $this->render('_standart',['result' => $result]) ?>

    <?php endif; ?>

    <?php if($result[0]->plan == 1): ?>

        <?= $this->render('_premium',[
                'result' => $result,
                'modelCallBack'   => $modelCallBack,
                'modelWriteToUs'  => $modelWriteToUs

        ]) ?>

    <?php endif; ?>









