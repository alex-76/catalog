<?php


namespace app\components;

use yii\helpers\Html;
use app\models\Post;
use yii\jui\Widget;
use Yii;

class CompanyWidget extends Widget
{

    public $html = '';

    public function init() {

        $model = Post::find()->
        joinWith('payments')->
        where(['post.access'=>'1'])->
        andWhere(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
        andWhere(['<=', 'date_publication', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
        orderBy('date_publication DESC')->
        limit(7)->
        all();

        $this->html.= '<ul class="list-unstyled last-company">';

        foreach ($model as $val) {
            $this->html .= '<li><a href="/show/' . $val->post_id . '/' . Yii::$app->translit->translit($val->name_company) . '">' . $val->name_company . '</a></li>';
        }
        $this->html.= '</ul>';

    }

    public function run()
    {
        return $this->html;
    }

}