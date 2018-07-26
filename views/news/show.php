<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Список новин', 'url'=> '/news/index'];
$this->params['breadcrumbs'][] =  'Губернатор завітав до селещної ради';
$this->title = $result[0]->title_news;

$this->registerCssFile('@web/css/news-show.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $result[0]->meta_keyword]);
$this->registerMetaTag(['name' => 'description', 'content' => $result[0]->meta_description]);
?>

<?= Breadcrumbs::widget([
    'homeLink' => ['label' => 'Головна', 'url' => '/'],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <img class="img-news" alt="<?=$result[0]->alt_image ?>" title="<?=$result[0]->title_image ?>" src='<?=$result[0]->getImage()->getUrl('180x') ?>'>
        <h1><?= $result[0]->name_news ?></h1>
        <p class="posted-on"><i>Автор</i> <?=$result[0]->author ?> <i>дата</i> <?=date('d.m.Y',strtotime($result[0]->date_news)) ?></p>
        <div><?= $result[0]->description ?></div>
    </div>
    <p class="text-right author-news"><?=$result[0]->author ?></p>
</div>
<div class="row">
    <div class="col-md-6">
        <?php if(!empty($prev_article[0]['news_id'])):  ?>
            <small>Попередня стаття:</small><br>
            <a href="<?= Url::to(['news/' . $prev_article[0]['news_id'] . '/' . Yii::$app->translit->translit($prev_article[0]['meta_keyword'])]) ?>"><?= $prev_article[0]['name_news']; ?></a>
        <?php endif;?>
    </div>
    <div class="col-md-6 text-right">
        <?php if(!empty($next_article[0]['news_id'])):  ?>
        <small>Наступна стаття:</small><br>
            <a href="<?= Url::to(['news/' . $next_article[0]['news_id'] . '/' . Yii::$app->translit->translit($next_article[0]['meta_keyword'])]) ?>"><?= $next_article[0]['name_news']; ?></a>
        <?php endif;?>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-12">
        <a name="reviews"></a>
        <?php if(Yii::$app->session->hasFlash('success-ok')):?>
            <div class="alert alert-success">
                <?php echo Yii::$app->session->getFlash('success-ok'); ?>
            </div>
        <?php endif; ?>

        <div class="header-h3">
            <?php if(!empty($model)): ?>
            Відгуки по статті: (<?= count($model); ?>)
            <?php endif;?>
            <a href="javascript:(0)" id="liev-reaplay" class="pull-right liev-reaplay" style="font-size: 14px; text-decoration: underline;">
                <span class="glyphicon glyphicon-share-alt"></span> Залишити відгук</a></div>

        <div id="panel-reaplay">
            <?php $form = ActiveForm::begin(['id' => 'active-form','action' => '/news/create']) ?>
             <?=  $form->field($review, 'name_user')->textInput(['placeholder' => "Імя"])->label(''); ?>
             <?=  $form->field($review, 'email')->textInput(['placeholder' => "Ваш Email"])->label(''); ?>
             <?=  $form->field($review, 'content')->textarea(['rows' => '3','placeholder' => "Відгук"])->label(''); ?>
             <?=  $form->field($review, 'news_id')->hiddenInput(['value' => $news_id])->label(false); ?>
             <?=  $form->field($review, 'meta_keyword')->hiddenInput(['value' => $meta_keyword])->label(false); ?>
             <?=  $form->field($review, 'access')->hiddenInput(['value' => '0'])->label(false); ?>
             <?=   Html::submitButton('Відправити', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end() ?>
        </div>

        <?php if(!empty($model)): ?>
        <?php foreach ($model as $val): ?>
        <div class="reaplay">
           <h5><span class="glyphicon glyphicon-user"></span> <strong><?=$val['name_user']?></strong>
               <span class="pull-right small"><span class="glyphicon glyphicon-calendar">
               </span> <?=date('d.m.Y H:i',strtotime($val['date_publication']))?></span></h5>
           <p><?=$val['content']?></p>
       </div><hr>
       <?php endforeach; ?>
       <?php endif;?>

    </div>
</div>

<?php
$js = <<<JS

$('#liev-reaplay').click(function(){    
    $('#panel-reaplay').toggle(300);    
});

JS;
$this->registerJs($js);
?>



