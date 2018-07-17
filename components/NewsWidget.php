<?php


namespace app\components;

use yii\helpers\Html;
use app\models\News;
use yii\jui\Widget;

class NewsWidget extends Widget
{

    public $html = '';

    public function init() {

        $model = News::find()->
        where(['access'=>'1'])->
        orderBy('date_news DESC')->
        limit(3)->
        all();

        foreach ($model as $val) {

            $this->html.= '<small><b>'.date('d.m.Y',strtotime($val['date_news'])).'</b></small>
                           <div class="last-news-head">
                           <a href="/news/'.$val['news_id'].'/'.\app\controllers\NewsController::translit($val['meta_keyword']).'">'.$val['name_news'].'</a></div>
                           <p class="last-news-content">'.\yii\helpers\StringHelper::truncate(strip_tags($val['description']),130,'...').'</p>';
        }
        $this->html .= '<p class="text-left"><a href="/news/index">Всі новини &#8594;</a></p>';

    }

    public function run()
    {
        return $this->html;
    }


}