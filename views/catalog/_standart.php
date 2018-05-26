


    <div class="row">
        <div class="col-md-12">
            <img alt="<?= $result[0]->name_company ?>" style="float:left;margin: 0 10px 10px 0;" src='<?=$result[0]->getImage()->getUrl('150x') ?>'>

            <p class="text-description"><?= \yii\helpers\StringHelper::truncate($result[0]->description,500,'...') ?></p>
            <div class="row">
                <div class="clearfix visible-sm"></div>
                <div class="clearfix visible-md"></div>
                <div class="clearfix visible-lg"></div>
                <div class="col-sm-6 col-md-6 info-client">
                    <div><b><span class="glyphicon glyphicon-home"></span> Адреса:</b></div>
                    <p class="text-primary"><?= $result[0]->address; ?></p>
                </div>
                <div class="col-sm-6 col-md-6 info-client">
                    <div><b><span class="glyphicon glyphicon-phone-alt"></span> Контакти:</b></div>
                    <p class="text-primary"><?= $result[0]->phone; ?></p>
                </div>
            </div>
            <div class="row info-client">
                <div class="col-sm-6 col-md-6">
                    <div><b><span class="glyphicon glyphicon-envelope"></span> Email:</b></div>
                    <p class="text-primary"><?= $result[0]->email; ?></p>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div><b><span class="glyphicon glyphicon-globe"></span> Сайт:</b></div>
                    <p class="text-primary"><?= $result[0]->url_site; ?></p>
                </div>
            </div>
        </div>
    </div>


