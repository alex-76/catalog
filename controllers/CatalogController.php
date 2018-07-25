<?php

namespace app\controllers;
use app\models\Area;
use app\models\Region;
use app\models\Subcategory;
use app\modules\admin\model\Payments;
use Yii;
use app\models\Post;
use app\models\Category;
use yii\web\Controller;
use yii\data\Pagination;
use yii\web\UploadedFile;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ModalForm;

class CatalogController extends Controller
{


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'app\components\MyCaptcha',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'foreColor' => 0x009688,
                'minLength' => 3,
                'maxLength' => 3,
                'offset' => 10,


            ],
        ];
    }

    public function actionIndex()
    {
        $result = Category::find()->
        with(['subcategory' => function ($query) {
            $query->orderBy('title ASC');
        }])->orderBy('name ASC')->all();

        if(empty($result)) throw  new \yii\web\HttpException(404,'Інформація відсутня');

        return $this->render('index', ['result' => $result]);

    }

    public function actionPost() {

        $subcat_id = Yii::$app->request->get('subcat_id');

        $count = Post::find()->
            joinWith('payments')->
            where(['post.subcategory_id' => $subcat_id,'post.access' => '1'])->
            andWhere(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            andWhere(['<=', 'date_publication', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            count();

        //if(empty($count)) throw  new \yii\web\HttpException(404,'Інформація в даній рубриці відсутня');
        if (empty($count)) {
            $result = Subcategory::find()->where(['subcategory_id' => $subcat_id])->all();
            return $this->render('noDataSubcategory', [
                'result' => $result,
                'massage' => 'Виберіть іншу підкатегорію'
            ]);
        }


        $pagination = new Pagination([
            'defaultPageSize' => 1,
            'totalCount' => $count,
            'forcePageParam' => false,
            'pageSizeParam' => false,
        ]);


        $result = Post::find()->
            joinWith('payments')->
            where(['post.subcategory_id' => $subcat_id,'post.access' => '1'])->
            andWhere(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            andWhere(['<=', 'date_publication', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            orderBy('plan DESC, date_publication DESC')->
            offset($pagination->offset)->
            limit($pagination->limit)->
            all();


        return $this->render('post',[
            'result' => $result,
            'pagination' => $pagination,
        ]);
    }

    public function actionShow() {

        $post_id = Yii::$app->request->get('post_id');

        $result = Post::find()->
            joinWith('payments')->
            where(['post.post_id' => $post_id,'post.access' => '1'])->
            andWhere(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            andWhere(['<=', 'date_publication', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            all();


        if(empty($result)) throw  new \yii\web\HttpException(404,'Інформація відсутня');

        $modelCallBack = new ModalForm();
        $modelCallBack->scenario = ModalForm::SCENARIO_CAllBACK;

        $modelWriteToUs = new ModalForm();
        $modelWriteToUs->scenario = ModalForm::SCENARIO_WRITETOUS;

        return $this->render('show',[
            'result' => $result,
            'modelCallBack'   => $modelCallBack,
            'modelWriteToUs'  => $modelWriteToUs
        ]);
    }

    public function actionAdd(){

        $post = new Post();

        if ($post->load(Yii::$app->request->post()))
        {

            $post->date_publication = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');

            if($post->save())
            {

               $lastID_post = Yii::$app->db->lastInsertID;

                // Add data in table payments
                (new Payments([
                    'enddate' => Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s'),
                    'post_id' => $lastID_post,
                ]))->save();

                $this->actionUploadfiles($lastID_post,$post);

                Yii::$app->session->setFlash('success-ok','Дякуємо! Ваша інформація успішно відправлена і наближчим часом з Вами звяжиться менеджер.');
                return $this->refresh();

            } else {
                Yii::$app->session->setFlash('error-ok','Помилка обробки даних');
            }
        }

        return $this->render('add',['form_model' => new Post()]);

    }

    public function actionFilter() {

        $arr = array();
        $reg_id = Yii::$app->request->get('reg_id', null);
        $area_id = Yii::$app->request->get('area_id', null);

        if ($area_id == null) {
            $arr = ['region_id' => $reg_id,'access' => '1'];
        } else {
            $arr = ['region_id' => $reg_id, 'area_id' => $area_id, 'access' => '1'];
        }

        $count = Post::find()->
            joinWith('payments')->
            where($arr)->
            andWhere(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            andWhere(['<=', 'date_publication', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            count();


        if (empty($count)) {           

            $result = (!empty($area_id)) ?
                Area::find()->with('region')->where(['region_id' => $reg_id, 'area_id' => $area_id])->all() :
                Area::find()->with('region')->where(['region_id' => $reg_id])->all();

            return $this->render('noDataLocation', [
                'result' => $result,
                'area_id' => $area_id
            ]);
        }


        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $count,
        ]);


        $result = Post::find()->
            with('region')->
            with('area')->
            joinWith('payments')->
            where($arr)->
            andWhere(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            andWhere(['<=', 'date_publication', Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')])->
            orderBy('plan DESC, date_publication DESC')->
            offset($pagination->offset)->
            limit($pagination->limit)->
            all();

        return $this->render('filter',[
            'result' => $result,
            'pagination' => $pagination,
            'area_id' => (!empty($area_id)) ? true : false
        ]);

    }

    public function actionPlan() {

        return $this->render('plan');
    }

    public function actionSearch() {

        $q  = Yii::$app->request->get('keyword',null);

        if(!empty($q)) {

            //$count = Post::find()->where(array('or like', 'description', ''.$q.''))->count();
            $query = "SELECT post.post_id 
                      FROM post
                      INNER JOIN payments  ON payments.post_id = post.post_id
                      WHERE description LIKE '%".$q."%' OR name_company LIKE '%".$q."%' AND
                            payments.enddate > '".Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')."' AND
                            post.date_publication <= '".Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')."' AND
                            post.access = '1'";
            $count = Post::findBySql($query)->count();
            if($count > 0){

                $pagination = new Pagination([
                    'defaultPageSize' => 10,
                    'totalCount' => $count,
                ]);

                $qu = "SELECT * 
                       FROM post 
                       INNER JOIN payments  ON payments.post_id = post.post_id
                       WHERE description LIKE '%".$q."%' OR name_company LIKE '%".$q."%' AND
                             payments.enddate > '".Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')."' AND
                             post.date_publication <= '".Yii::$app->formatter->asDate(time()+10800, 'php:Y-m-d H:i:s')."' AND
                             post.access = '1'
                       ORDER BY post.plan DESC, post.date_publication DESC";
                $result = Post::findBySql($qu)->
                offset($pagination->offset)->limit($pagination->limit)->all();

            } else {

                Yii::$app->session->setFlash('no-result','По запиту нічого не знайдено');
            }
        } else {
            Yii::$app->session->setFlash('no-query','Вкажіть необхідний запит');
        }
        //if(empty($count)) throw  new \yii\web\HttpException(404,'Інформація відсутня');

        return $this->render('search',[
            'pagination' => !empty($pagination)?$pagination:null,
            'result'     => !empty($result)?$result:null,
            'q'          => $q,
            'count'      => !empty($count)?$count:0,
            ]
        );
    }

    /*
     * Add files
     */
    public function actionUploadfiles($id,$model){

        $model->image = UploadedFile::getInstance($model,'image');

        if($model->image!== null) {
            $model->upload($id);
        }
        unset($model->image);

        $model->gallery = UploadedFile::getInstances($model,'gallery');
        $model->uploadGallery($id);


    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect('/admin/default/index');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
