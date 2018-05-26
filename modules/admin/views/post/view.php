<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\model\Post */

$this->title = $model->name_company;
$this->params['breadcrumbs'][] = ['label' => 'Список публікацій', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><img src="/images/admin/pixam-icon.jpg" width="70"> <?= Html::encode($this->title) ?></h1>

    <?= Breadcrumbs::widget([
        'homeLink' => ['label' => 'Головна', 'url' => '/admin/default/'],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <p>
        <?= Html::a('Редагувати', ['update', 'id' => $model->post_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->post_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ви впевнені, що ви хочите видалити цю публікаію?',
                'method' => 'post',
            ],
        ]) ?>
    </p>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'post_id',
            'name_company',
            'name_client',
            'address',
            'email:email',
            'phone',
            'url_site:url',
            'description:html',
            [
                'attribute' => 'category_id',
                'label'=>'Рубрика',
                'contentOptions' => ['style' => ''],
                'captionOptions' => ['style' => 'width:180px'],
                'format' => 'raw',
                'value' => function($data){
                    return $data->category->name;
                }
            ],
            [
                'attribute' => 'subcategory_id',
                'label'=>'Підрубрика',
                'format' => 'raw',
                'value' => function($data){
                    return $data->subcategory->title;
                }
            ],
            [
                'attribute' => 'region_id',
                'label'=>'Область',
                'format' => 'raw',
                'value' => function($data){
                    return $data->region->name_region;
                }
            ],
            [
                'attribute' => 'area_id',
                'label'=>'Район',
                'format' => 'raw',
                'value' => function($data){
                    return $data->area->name;
                }
            ],
            [
                'attribute' => 'plan',
                'label'=>'Тарифний план',
                'format' => 'raw',
                'value' => function($data){
                    return ($data->plan == 1)?'Преміум' : 'Стандарт';
                }
            ],
            [
                'attribute'=>'date_publication',
                'label'=>'Дата початку публікації',
                //'format' => ['datetime', 'php:d M Y / h:i:s'],
                'options' => ['width' => '200'],
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';// эта запись устанавливает часовой пояс такой же как на сервере
                    return Yii::$app->formatter->asDatetime($data->date_publication, "php:d.m.Y H:i:s");
                }

            ],
            [
                'attribute'=>'payments',
                'label'=>'Дата закінчення публікації',
                //'format' => ['datetime', 'php:d M Y / h:i:s'],
                'options' => ['width' => '200'],
                'value' => function($data){
                    Yii::$app->formatter->timeZone = 'UTC';
                    return Yii::$app->formatter->asDatetime($data->payments->enddate, "php:d.m.Y H:i:s");
                }

            ],
            [
                'attribute'=>'images',
                'label'=>'Прикріплені файли',
                'format' => 'raw',
                'value' => function($data){

                    $arr = array();

                    if(count($data->getImages()) > 0) {

                        foreach ($data->getImages() as $img) {

                            if(!empty($img->itemId))
                            {
                                if($img->extension == 'jpg' || $img->extension == 'png' || $img->extension == 'gif') {
                                    $arr[] = Html::img($img->getUrl(),['class'=>'img_attachment','style'=>'width:85px']);
                                }
                                else {
                                    $arr[] =  Html::a($img->name.'.'.$img->extension, '/images/store/'.$img->filePath). ' ';
                                }
                            }
                        }
                        return implode(' ',$arr);
                    }
                },
            ],


            'logo_name',
            'meta_description',
            'keywords',
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
        ],
    ]) ?>

</div>