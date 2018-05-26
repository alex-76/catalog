<?php


namespace app\components;

use yii\helpers\Html;
use app\modules\admin\model\Banner;
use yii\jui\Widget;

class BannerWidget extends Widget
{

    public $html = '';

    public function init() {

        $model = Banner::find()->
        where(['accsess'=>'1'])->
        andWhere(['>', 'date_end', date('Y-m-d H:i:s',time()+3600)])->
        andWhere(['<=', 'date_begin', date('Y-m-d H:i:s',time()+3600)])->
        orderBy('position DESC')->
        all();

        $count = Banner::find()->
        where(['accsess'=>'1'])->
        andWhere(['>', 'date_end', date('Y-m-d H:i:s',time()+3600)])->
        andWhere(['<=', 'date_begin', date('Y-m-d H:i:s',time()+3600)])->
        count();

        if ($count > 0) {

            $this->html .= '<div class="header-h3" id="top-company"><span class="glyphicon glyphicon-stats"></span> ТОП ' . $count . ' компаній</div>';

            foreach ($model as $val) {

                foreach ($val->getImages() as $img) {
                    $this->html .= '<a target="_blank" href="http://' . $val->url . '" ' . implode(explode(" ", $val->attributes)) . '>' . Html::img($img->getUrl('250x'), ['class' => 'img_attachment']) . '</a>';
                    $this->html .= '<div class="clearfix visible-sm"></div><div class="clearfix visible-xs"></div>';
                }
            }
        }
    }

    public function run()
    {
        return $this->html;
    }
}