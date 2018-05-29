<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->registerCssFile('@web/css/plagins/jquery.zbox.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile("@web/js/plagins/jquery.zbox.js",['depends' =>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/plagins/lightbox.js",['depends' =>'yii\web\YiiAsset']);
$this->registerJsFile("js/contact.js",['depends' =>'yii\web\YiiAsset']);
$this->registerJsFile("js/g.map.js",['depends' =>'yii\web\YiiAsset']);
$this->registerJsFile("https://maps.googleapis.com/maps/api/js?key=AIzaSyDXZwI4SpcHd_WIqitk3E0M1LN629rvk64",['depends' =>'yii\web\YiiAsset']);


?>



<div class="row">
    <div class="col-md-12">
        <img alt="<?= $result[0]->name_company ?>" style="float:left;margin: 0 7px 10px 0;" src='<?=$result[0]->getImage()->getUrl('150x') ?>'>

        <p class="text-description"><?= \yii\helpers\StringHelper::truncate($result[0]->description,1000,'...') ?></p>

        <div class="row">
            <div class="clearfix visible-xs"></div>
            <div class="clearfix visible-sm"></div>
            <div class="clearfix visible-md"></div>
            <div class="clearfix visible-lg"></div>

            <div class="col-md-6 info-client">
                <div><b><span class="glyphicon glyphicon-home"></span> Адреса:</b></div>
                <p class="text-primary"><?= $result[0]->address; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 info-client">
                <div><b><span class="glyphicon glyphicon-phone-alt"></span> Контакти:</b></div>
                <p class="text-primary"><?= $result[0]->phone; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 info-client">
                <div><b><span class="glyphicon glyphicon-envelope"></span> Email:</b></div>
                <p class="text-primary"><?= $result[0]->email; ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 info-client">
                <div><b><span class="glyphicon glyphicon-globe"></span> Сайт:</b></div>
                <p class="text-primary"><a href="http://<?= $result[0]->url_site; ?>" target="_blank" rel="nofollow">
                        <?= $result[0]->url_site; ?>
                    </a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 info-client">
                <?php $count = count($result[0]->getImages()); if($count > 0): ?>
                    <div style="margin-bottom: 7px"><b><span class="glyphicon glyphicon-paperclip"></span> Додаткова інформація:</b></div>
                    <?php
                        foreach ($result[0]->getImages() as $img) {

                            if($img['isMain']!= 1 && !empty($img->itemId))
                            {
                                if($img->extension == 'jpg' || $img->extension == 'png' || $img->extension == 'gif') {
                                    echo HTML::a(Html::img($img->getUrl(),['class'=>'img_attachment','style'=>'width:85px']),''.$img->getUrl().'',['class'=>'zb','rel'=>'group']);
                                }
                                else {
                                    echo  Html::a($img->name.'.'.$img->extension, '/images/store/'.$img->filePath). ' ';
                                }
                            }
                        }
                ?>
                <?php endif;?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 connect-client">
                <div class="btn-group">
                    <a href="javascript:(0)" class="btn btn-default btn-lg callBack" data-toggle="modal" data-target="#callBack">
                        <span class="glyphicon glyphicon glyphicon-earphone"></span>
                    </a>
                    <a href="javascript:(0)" class="btn btn-default btn-lg writeToUs" data-toggle="modal" data-target="#writeToUs">
                        <span class="glyphicon glyphicon glyphicon-envelope"></span>
                    </a>
                </div>
                <div class="dropdown pull-right">
                    <a data-toggle="dropdown" href="#" class="btn btn-default firm-share">
                        Поділитись <span class="item-share"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a href="https://www.facebook.com" target="_blank">
                                <img alt="facebook" width="18" src="/images/facebook.svg"> <span>Facebook</span></a>
                        </li>
                        <li><a href="https://twitter.com" target="_blank">
                                <img alt="twitter" width="18" src="/images/twitter.svg"> <span>Twitter</span></a>
                        </li>
                        <li><a href="https://plus.google.com" target="_blank">
                                <img alt="gplus" width="18" src="/images/gplus.png"> <span>Google+</span></a>
                        </li>
                        <li><a href="https://www.youtube.com/" target="_blank">
                                <img alt="youtube" width="18" src="/images/youtube.svg"> <span>Youtube</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <span id="postID" style="display: none"><?= $result[0]->post_id; ?></span>
    </div>
</div>
<div class="row">
    <div class="col-md-12"  >
        <hr>
        <div id="map" style="height:400px"></div>
    </div>
</div>

<!-- Modal callBack -->
<div class="modal fade" id="callBack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel-callBack">Замовити дзвінок</h4>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'callBack-form',
                'options' => ['class' => 'form-horizontal'],

            ]); ?>
            <div class="modal-body">
                <?= $form->field($modelCallBack, 'name')->textInput(['placeholder' => "Ім'я",'id'=>'modalform-name-callback'])->label(''); ?>
                <?= $form->field($modelCallBack, 'tel')->textInput(['placeholder' => "Ваш телефон",'id'=>'modalform-tel-callback'])->label(''); ?>
                <?= $form->field($modelCallBack, 'email')->textInput(['placeholder' => "Ваша електронна пошта",'id'=>'modalform-email-callback'])->label(''); ?>
                <?= $form->field($modelCallBack, 'theme')->textInput(['placeholder' => "Вас цікавить",'id'=>'modalform-thema-callback'])->label(''); ?>
                <?= $form->field($modelCallBack, 'text')->textarea(['rows' => 4,'placeholder' => "Текст повідомлення",'id'=>'modalform-text-callback'])->label(''); ?>
                <?= $form->field($modelCallBack, 'flag')->hiddenInput(['value' => 1,'id'=>'modalform-flag-callback'])->label(false);  ?>
                <?= Html::hiddenInput('ModalForm[company_email]', $result[0]->email) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Відмінити</button>
                <button type="button" class="btn btn-primary" id="order_callBack">Замовити</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal writeToUs -->
<div class="modal fade" id="writeToUs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel-writeToUs">Написати повідомлення</h4>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'writeToUs-form',
                'options' => ['class' => 'form-horizontal'],

            ]); ?>
            <div class="modal-body">
                <?= $form->field($modelWriteToUs, 'name')->textInput(['placeholder' => "Ім'я",'id'=>'modalform-name-writetous'])->label(''); ?>
                <?= $form->field($modelWriteToUs, 'email')->textInput(['placeholder' => "Ваша електронна пошта",'id'=>'modalform-email-writetous'])->label(''); ?>
                <?= $form->field($modelWriteToUs, 'tel')->textInput(['placeholder' => "Ваш телефон",'id'=>'modalform-tel-writetous'])->label(''); ?>
                <?= $form->field($modelWriteToUs, 'theme')->textInput(['placeholder' => "Вас цікавить",'id'=>'modalform-thema-writetous'])->label(''); ?>
                <?= $form->field($modelWriteToUs, 'text')->textarea(['rows' => 4,'placeholder' => "Текст повідомлення",'id'=>'modalform-text-writetous'])->label(''); ?>
                <?= $form->field($modelWriteToUs, 'flag')->hiddenInput(['value' => 2,'id'=>'modalform-flag-writetous'])->label(false);  ?>
                <?= Html::hiddenInput('ModalForm[company_email]', $result[0]->email) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Відмінити</button>
                <button type="button" class="btn btn-primary" id="order_writeToUs">Відправити</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal info -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel-info">Увага</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>



