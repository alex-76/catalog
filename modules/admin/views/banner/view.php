<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Banner */

$this->title = 'Банер № '.$model->banner_id;
$this->params['breadcrumbs'][] = ['label' => 'Банера', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-view">

    <h1><img src="/images/admin/banner-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Обновити', ['update', 'id' => $model->banner_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->banner_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочите видалити даний банер?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'banner_id',
            'name_company',
            [
                'attribute'=>'date_begin',
                'label'=>'Дата початку публікації',
                //'format' => ['datetime', 'php:d M Y / h:i:s'],
                'options' => ['width' => '200'],
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';// эта запись устанавливает часовой пояс такой же как на сервере
                    return Yii::$app->formatter->asDatetime($data->date_begin, "php:d.m.Y H:i:s");
                }

            ],
            [
                'attribute'=>'date_end',
                'label'=>'Дата кінця публікації',
                //'format' => ['datetime', 'php:d M Y / h:i:s'],
                'options' => ['width' => '200'],
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';// эта запись устанавливает часовой пояс такой же как на сервере
                    return Yii::$app->formatter->asDatetime($data->date_end, "php:d.m.Y H:i");
                }

            ],
            'url',
            [
                'attribute'=>'images',
                'label'=>'Прикріплені файли',
                'format' => 'raw',
                'value' => function($data){

                    $arr = array();

                    if(count($data->getImages()) > 0) {

                        foreach ($data->getImages() as $img) {

                            if(!empty($img->itemId)) {

                               $arr[] = Html::img($img->getUrl(),['class'=>'img_attachment','style'=>'width:85px']);
                            }
                        }
                        return implode(' ',$arr);
                    }
                },
            ],
            'position',
            [
                'attribute' => 'accsess',
                'label'=>'Статус',
                'format' => 'raw',
                'value' => function($data){
                    return ($data->accsess == 1)?
                        '<span style="color:#008000">Активовано</span>' :
                        '<span style="color:#de0810">Деактивовано</span>';
                }
            ],

        ],
    ]) ?>

</div>
