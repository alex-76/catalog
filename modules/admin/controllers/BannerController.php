<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\model\Banner;
use app\modules\admin\model\BannerSearch;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends AppAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BannerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banner model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();
        $model->position = Banner::find()->max('position')+1;

        if ($model->load(Yii::$app->request->post())) {

            var_dump(Yii::$app->request->post());

            if($model->save()){

                print 3;

               $this->actionUploadfiles($model);

               return $this->redirect(['view', 'id' => $model->banner_id]);

           }


        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->actionUploadfiles($model);

            return $this->redirect(['view', 'id' => $model->banner_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Banner::find()->where(['banner_id' => $id])->all();
        foreach($model[0]->getImages() as $image){
            $model[0]->removeImage($image);
        }
        FileHelper::removeDirectory('images/store/Banners/Banner'.$id);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
     * Add files
     */
    public function actionUploadfiles($model){

        $model->image = UploadedFile::getInstance($model,'image');

        if($model->image!== null) {
            $model->upload();
        }
        unset($model->image);

    }

    /*
 * Delete files
 */
    public function actionDeletemoreimg(){

        $banner_id = Yii::$app->request->get('banner_id');
        $id = Yii::$app->request->get('id');
        $all_img = Yii::$app->request->get('all_img');

        $model = Banner::find()->where(['banner_id' => $banner_id])->all();

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

        return $this->redirect(["/admin/banner/update?id=".$banner_id.""]);

    }

    /*
     * Change position banners
     */
    public function actionChangeposition() {

        $pos = Yii::$app->request->get('pos');
        $bid = Yii::$app->request->get('bid');
        $n = Yii::$app->request->get('n');

        if($n == 'up') {
            $ofset = $pos + 1;
        } else {
            $ofset = $pos - 1;
        }

        $query = Banner::find()->select(['banner_id', 'position'])->where(['position' => $ofset])->all();
        if (!empty($query)) {

            $next_banner_id = $query[0]['banner_id'];
            $next_banner_position = $query[0]['position'];
            Banner::updateAll(['position' => $ofset], ['like', 'banner_id', $bid]);
            Banner::updateAll(['position' => ($n == 'up')?$next_banner_position - 1:$next_banner_position + 1], ['like', 'banner_id', $next_banner_id]);

        }

        $this->redirect('/admin/banner/index');
    }
}
