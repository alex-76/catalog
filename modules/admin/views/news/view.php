<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->name_news;
$this->params['breadcrumbs'][] = ['label' => 'Новини', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><img src="/images/admin/news-icon.png" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Обновити', ['update', 'id' => $model->news_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->news_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що хочите видалити цю новину?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute'=>'news_id',
                'label'=>'ID',
                'options' => ['width' => '300'],
            ],
            'title_news',
            'name_news',

            [
                'attribute'=>'description',
                'label'=>'Опис',
                'format' => 'html',
            ],
            'meta_keyword',
            'meta_description',
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
            'alt_image',
            'title_image',

            [
                'attribute' => 'access',
                'label'=>'Статус',
                'format' => 'raw',
                'value' => function($data){
                    return ($data->access == 1)?
                        '<span style="color:#008000">Активовано</span>' :
                        '<span style="color:#de0810">Деактивовано</span>';
                }
            ],
            [
                'attribute'=>'date_news',
                'label'=>'Дата початку публікації',
                'options' => ['width' => ''],
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';
                    return Yii::$app->formatter->asDatetime($data->date_news, "php:d.m.Y H:i:s");
                }

            ],
        ],
    ]) ?>

</div>
