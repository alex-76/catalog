<?php

namespace app\controllers;

use app\models\News;
use app\models\Reviews;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use Yii;

class NewsController extends \yii\web\Controller
{
    public $layout = 'news';

    /*
     * List news
     */
    public function actionIndex()
    {

        $count = News::find()->where(['access' => '1'])->count();

        if(empty($count)) throw  new \yii\web\HttpException(404,'Інформація відсутня');

        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $count,
        ]);

        $result = News::find()->
        with('reviews')->
        where(['access' => '1'])->
        orderBy('news_id DESC')->
        offset($pagination->offset)->
        limit($pagination->limit)->
        all();


        return $this->render('index',[
            'result' => $result,
            'pagination' => $pagination,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);
    }

    /*
     * Show selected new
     */
    public function actionShow(){


        $news_id = Yii::$app->request->get('news_id');

        $result = News::find()->where(['news_id' => $news_id,'access' => '1'])->all();
        if(empty($result)) throw  new \yii\web\HttpException(404,'Інформація відсутня');

        $next_article = News::find()->
                where(['access' => '1'])->
                andWhere(['>', 'news_id', $news_id])->
                orderBy('news_id ASC')->
                limit(1)->
                all();

        $prev_article = News::find()->
                where(['access' => '1'])->
                andWhere(['<', 'news_id', $news_id])->
                orderBy('news_id DESC')->
                limit(1)->
                all();


        return $this->render('show',[
            'result' => $result,
            'review' => new Reviews(),
            'model'  => Reviews::find()->where(['news_id' => $news_id,'access' => '1'])->asArray()->orderBy('date_publication DESC')->all(),
            'next_article' => !empty($next_article)?$next_article:null,
            'prev_article' => !empty($prev_article)?$prev_article:null,
            'news_id' => $news_id,
            'meta_keyword' => self::translit($result[0]['meta_keyword'],true),
        ]);


    }

    /*
     * Add & create review for new
     */
    public function actionCreate()
    {
        $model = new Reviews();

        if ($model->load(Yii::$app->request->post())) {

            $model->date_publication = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');

            if($model->save()) {

                Yii::$app->session->setFlash('success-ok','Дякуємо за ваш відгук. Після перевірки модератором він буде опублікований на сайті.');

                return $this->redirect('/news/'.$model->news_id.'/'.$_POST['Reviews']['meta_keyword'].'#reviews');
            }
        }

        throw  new \yii\web\HttpException(404,'Інформація відсутня');
    }





    public  static function translit($str, $fix_umlauts=false) {

        // Установить опции и кодировку регулярных выражений
        mb_regex_set_options('pd');
        mb_internal_encoding('UTF-8');

        // Привести строку к UTF-8
        if (strtolower(mb_detect_encoding($str,
                'utf-8, windows-1251'))=='windows-1251') {
            $str=mb_convert_encoding($str, 'utf-8', 'windows-1251');
        }

        // Регулярки для удобства
        $regexp1='(?=[A-Z0-9А-Я])';
        $regexp2='(?<=[A-Z0-9А-Я])';

        // Массивы для замены заглавных букв, идущих последовательно
        $rus=array(
            '/(Ё'.$regexp1.')|('.$regexp2.'Ё)/u',
            '/(Ж'.$regexp1.')|('.$regexp2.'Ж)/u',
            '/(Ч'.$regexp1.')|('.$regexp2.'Ч)/u',
            '/(Ш'.$regexp1.')|('.$regexp2.'Ш)/u',
            '/(Щ'.$regexp1.')|('.$regexp2.'Щ)/u',
            '/(Ю'.$regexp1.')|('.$regexp2.'Ю)/u',
            '/(Я'.$regexp1.')|('.$regexp2.'Я)/u'
        );

        $eng=array(
            'YO','ZH','CH','SH','SCH','YU','YA'
        );

        // Заменить заглавные буквы, идущие последовательно
        $str=preg_replace($rus,$eng,$str);

        // Массивы для замены одиночных заглавных и строчных букв
        $rus=array(
            '/а/u','/б/u','/в/u','/г/u','/д/u','/е/u','/ё/u',
            '/ж/u','/з/u','/и/u','/й/u','/к/u','/л/u','/м/u',
            '/н/u','/о/u','/п/u','/р/u','/с/u','/т/u','/у/u',
            '/ф/u','/х/u','/ц/u','/ч/u','/ш/u','/щ/u','/ъ/u',
            '/ы/u','/ь/u','/э/u','/ю/u','/я/u',

            '/А/u','/Б/u','/В/u','/Г/u','/Д/u','/Е/u','/Ё/u',
            '/Ж/u','/З/u','/И/u','/Й/u','/К/u','/Л/u','/М/u',
            '/Н/u','/О/u','/П/u','/Р/u','/С/u','/Т/u','/У/u',
            '/Ф/u','/Х/u','/Ц/u','/Ч/u','/Ш/u','/Щ/u','/Ъ/u',
            '/Ы/u','/Ь/u','/Э/u','/Ю/u','/Я/u'
        );

        $eng=array(
            'a','b','v','g','d','e','yo',
            'zh','z','i','y','k','l','m',
            'n','o','p','r','s','t','u',
            'f','h','c','ch','sh','sch','',
            'i','','e','yu','ya',

            'A','B','V','G','D','E','Yo',
            'Zh','Z','I','Y','K','L','M',
            'N','O','P','R','S','T','U',
            'F','H','C','Ch','Sh','Sch','',
            'I','','E','Yu','Ya'
        );

        // Заменить оставшиеся заглавные и строчные буквы
        $str=preg_replace($rus,$eng,$str);
        $str=str_replace(['-','–','—',',',':','\''], "", $str);
        $str=str_replace(" ", "-", $str); // заменяем пробелы знаком минус

        // Исправление умляутов и других надсимвольных значков
        if ($fix_umlauts) {
            $str=preg_replace('/&(.)(tilde|uml);/',"$1",
                mb_convert_encoding($str,'HTML-ENTITIES','utf-8'));
        }

        return $str;
    }

}
