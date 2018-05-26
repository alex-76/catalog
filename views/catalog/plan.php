<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->registerCssFile('@web/css/plagins/jquery.zbox.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile("@web/js/plagins/jquery.zbox.js",['depends' =>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/plagins/lightbox.js",['depends' =>'yii\web\YiiAsset']);

$this->title = 'Тарифи розміщення інформації';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <h3>Тарифи розміщення інформації</h3>

        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => 'Головна', 'url' => '/'],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <p>«Панорама Полтавщини» – обласна щотижнева суспільно-політична газета.  Її створив колектив полтавських журналістів-професіоналів,
            які об'єднались, щоб нормально працювати та доносити до читачів об’єктивну й достовірну інформацію.
            Газета виходить щотижня та розповсюджується за передплатою і в роздрібній торгівлі. Територія розповсюдження –
            Полтавська область, методи розповсюдження: передплата, роздрібна торгівля, електронна розсилка.</p>

        <a class='zb' rel='group' href="/images/standart.jpg"> <img style="border: 1px solid #d7d7d7" src="/images/standart.jpg" width="500"></a>

        <p>«Панорама Полтавщини» – обласна щотижнева суспільно-політична газета.  Її створив колектив полтавських журналістів-професіоналів,
            які об'єднались, щоб нормально працювати та доносити до читачів об’єктивну й достовірну інформацію.
            Газета виходить щотижня та розповсюджується за передплатою і в роздрібній торгівлі. Територія розповсюдження –
            Полтавська область, методи розповсюдження: передплата, роздрібна торгівля, електронна розсилка.</p>
        <p>(0532) 69-02-69,</p>
        <p>050 216-00-69,</p>
        <p>099 021-03-59,</p>
        <p>096 906-62-13.</p>
        <p>panorama.pl.ltd@gmail.com</p>
    </div>
</div>