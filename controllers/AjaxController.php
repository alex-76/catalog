<?php


namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Area;
use app\models\Subcategory;
use app\models\Post;
use app\models\ModalForm;
use app\modules\admin\model\Subscription;



class AjaxController extends Controller
{
    public function filters() {
        return array(
            'ajaxOnly + area, subcategory, subscription, sendemail, info, order, query',
        );
    }

    // Show list area
    public function actionArea(){

        if(\Yii::$app->request->isAjax) {

            $res = \Yii::$app->getResponse();
            $res->format = \yii\web\Response::FORMAT_JSON;

            if(Yii::$app->request->post('act') == 'area')
            {
                $query = Area::find()->where(['region_id' => Yii::$app->request->post('region_id')])->all();

                if(count($query)) {

                    foreach ($query as $val) {
                        $arr[] = '<option value="'.$val->area_id.'">'.$val->name.'</option>';
                    }

                } else {
                    $arr[] = '<option value="">Виберіть район...</option>';
                }
            } else {
                $arr[] = '<option value="">Виберіть район...</option>';
            }
            $res->data = array('result'=>$arr);
            $res->send();

        }
    }

    // Show list area
    public function actionSubcategory(){

        if(\Yii::$app->request->isAjax) {

            $res = \Yii::$app->getResponse();
            $res->format = \yii\web\Response::FORMAT_JSON;

            if(Yii::$app->request->post('act') == 'subcategory') {
                $query = Subcategory::find()->where(['category_id' => Yii::$app->request->post('category_id')])->all();

                if(count($query)) {

                    foreach ($query as $val) {
                        $arr[] = '<option value="'.$val->subcategory_id.'">'.$val->title.'</option>';
                    }

                } else {
                    $arr[] = '<option value="">Виберіть підрубрику...</option>';
                }
            } else {
                $arr[] = '<option value="">Виберіть підрубрику...</option>';
            }
            $res->data = array('result'=>$arr);
            $res->send();


        }
    }

    // Add subscription email
    public function actionSubscription() {

        if(\Yii::$app->request->isAjax) {

            $res = \Yii::$app->getResponse();
            $res->format = \yii\web\Response::FORMAT_JSON;
            $email = trim(Yii::$app->request->post('email'));

            $model = new Subscription();
            $count = Subscription::find()->where(['email' => $email])->count();
            if($count == 0) {
                $model->email = $email;
                $model->date = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');
                if($model->save() && $model->checkEmail()) {
                    $status = 1;
                } else {
                    $status = 0;
                }
            } else {
                $status = 2;
            }
            $res->data = array('result' => $status);
            $res->send();
        }
    }

    // Subscription send email
    public function actionSendemail () {

        if(\Yii::$app->request->isAjax) {

            $res = \Yii::$app->getResponse();
            $res->format = \yii\web\Response::FORMAT_JSON;
            $model = new Subscription();

            $model->emailFrom = 'info.catalog.ua@gmail.com';

            if(Subscription::find()->count() > 0){
                $query = Subscription::find()->asArray()->all();
                $s = '';
                foreach ($query as $val) {
                    $model->send($val['email']);
                }
            }

            $res->data = array('result' => 1);
            $res->send();
        }

    }

    // Give info for clint from DB
    public function actionInfo()
    {
        if (\Yii::$app->request->isAjax) {

            $res = \Yii::$app->getResponse();
            $res->format = \yii\web\Response::FORMAT_JSON;

            $id = Yii::$app->request->post('id');
            $query = Post::find()->where(['post_id' => $id])->all();

            if(count($query)) {
                $name    = $query[0]->name_company;
                $address = $query[0]->address;
                $tel     = $query[0]->phone;
                $email   = $query[0]->email;
                $site    = (!empty($query[0]->url_site))?$query[0]->url_site:'-';
            }

            $res->data = array(
                'name'    => $name,
                'address' => $address,
                'tel'     => $tel,
                'email'   => $email,
                'site'    => $site
            );
            $res->send();
        }
    }

    // Make callBack
    public function actionOrder() {

        if (\Yii::$app->request->isAjax) {

            $res = \Yii::$app->getResponse();
            $res->format = \yii\web\Response::FORMAT_JSON;

            $model = new ModalForm();

            if ($model->load(Yii::$app->request->post())) {

                $model->name = $_POST['ModalForm']['name'];
                $model->tel =  $_POST['ModalForm']['tel'];
                $flag = ($_POST['ModalForm']['flag'] == 1)?'Замовлення дзвінка':'Повідомлення від клієнта';

                $model->send(''.$_POST['ModalForm']['company_email'].'', $flag);
                $r = true;

            } else {
                $r = false;
            }

            $res->data = array('r' => $r);
            $res->send();
        }

    }

    /**
     * Return list queries users in search company
     */
    public function actionQuery() {

        if (\Yii::$app->request->isAjax) {

            $q = trim(Yii::$app->request->get('q'));

            $query = "SELECT post.name_company, category.name
                      FROM post
                      INNER JOIN payments  ON payments.post_id = post.post_id
                      INNER JOIN category  ON category.category_id = post.category_id
                      WHERE name_company LIKE '%".$q."%' AND
                            payments.enddate > '".Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')."' AND
                            post.date_publication <= '".Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')."' AND
                            post.access = '1'";

            $result = Post::findBySql($query)->asArray()->all();

            foreach($result as $val) {
                echo $val['name_company']."|".$val['name']."\r\n";
            }

        }

    }




}