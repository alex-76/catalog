<?php

namespace app\modules\admin\controllers;

use app\modules\admin\model\Area;
use app\modules\admin\model\Category;
use app\modules\admin\model\Subcategory;
use app\modules\admin\model\Region;
use app\modules\admin\model\Payments;
use Yii;
use app\modules\admin\model\Post;
use app\modules\admin\model\PostSearch;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;


/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends AppAdminController
{



    /*
    * Функция, получающая из метки времени в формате UNIX TIME
    * месяцы, дни, часы, минуты и секунды
    * $t - значение UNIX timestamp, которое нужно перевести
    * в месяцы, дни, часы, минуты и секунды
    */

    public static function Parsetimestamp( $t = 0 )
    {
        $month = floor( $t / 2592000 );
        $day = ( $t / 86400 ) % 30;
        $hour = ( $t / 3600 ) % 24;
        $min = ( $t / 60 ) % 60;
        $sec = $t % 60;

        return array( 'month' => $month, 'day' => $day, 'hour' => $hour, 'min' => $min, 'sec' => $sec );
    }



    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;
        $dataProvider->setSort([
            'defaultOrder' => ['post_id'=>SORT_DESC],]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $result = Post::find()->where(['post_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'result'=>$result,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $modelPayments = new Payments();


        $queryCategory = Category::find()->asArray()->orderBy('name')->all();
        $querySubcategory = Subcategory::find()->asArray()->orderBy('title')->all();
        $queryRegion = Region::find()->asArray()->orderBy('name_region')->all();
        $queryArea = Area::find()->asArray()->orderBy('name')->all();

        if ($model->load(Yii::$app->request->post()) && $modelPayments->load(Yii::$app->request->post())) {

            $model->description = strip_tags($model->description, '<a>');

            $isValid = $model->validate();
            $isValid = $modelPayments->validate() && $isValid;

            if ($isValid) {
                $model->save(false);
                $lastID_post = Yii::$app->db->lastInsertID;
                $modelPayments->post_id = $lastID_post;
                $modelPayments->save(false);

                $this->actionUploadfiles($lastID_post,$model);

                return $this->redirect(['view', 'id' => $model->post_id]);

            }

        }

        return $this->render('create', [
            'model' => $model,
            'modelPayments' => $modelPayments,
            'modelCategory' => $queryCategory,
            'modelSubcategory' => $querySubcategory,
            'modelRegion' => $queryRegion,
            'modelArea' => $queryArea,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $queryCategory = Category::find()->asArray()->orderBy('name')->all();
        $querySubcategory = Subcategory::find()->asArray()->orderBy('title')->all();
        $queryRegion = Region::find()->asArray()->orderBy('name_region')->all();
        $queryArea = Area::find()->asArray()->orderBy('name')->all();

        $model = $this->findModel($id);
        $modelPayments = Payments::findOne(['post_id' => $id]);

        if (!isset($modelPayments)) {
            throw new NotFoundHttpException("The payments was not found.");
        }

        if ($model->load(Yii::$app->request->post()) && $modelPayments->load(Yii::$app->request->post())) {

            $model->description = strip_tags($model->description, '<a>');
            $isValid = $model->validate();
            $isValid = $modelPayments->validate() && $isValid;
            if ($isValid) {
                $model->save(false);
                $modelPayments->save(false);

                $this->actionUploadfiles($id,$model);

                return $this->redirect(['view', 'id' => $model->post_id]);

            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelPayments' => $modelPayments,
            'modelCategory' => $queryCategory,
            'modelSubcategory' => $querySubcategory,
            'modelRegion' => $queryRegion,
            'modelArea' => $queryArea,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Post::find()->where(['post_id' => $id])->all();
        foreach($model[0]->getImages() as $image){
           $model[0]->removeImage($image);
        }
        FileHelper::removeDirectory('images/store/Posts/Post'.$id);

        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
     * Delete files
     */
    public function actionDeletemoreimg(){

        $post_id = Yii::$app->request->get('post_id');
        $id = Yii::$app->request->get('id');
        $all_img = Yii::$app->request->get('all_img');

        $model = Post::find()->where(['post_id' => $post_id])->all();

        $images = $model[0]->getImages();

        foreach($images as $image){

            if(!empty($all_img)) {
                $model[0]->removeImage($image);
            } else {
                if($image->id == $id){
                    $model[0]->removeImage($image);
                    break;
                }
            }
        }

        return $this->redirect(["/admin/post/update?id=".$post_id.""]);

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






}
