<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\model\Payments;
use app\modules\admin\model\PaymentsSearch;
use yii\web\NotFoundHttpException;



class PaymentsController extends AppAdminController
{


   /*
    public function actionIndex()
    {
        $searchModel = new PaymentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Payments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pay_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/


    /*
   public function actionDelete($id)
   {
       $this->findModel($id)->delete();

       return $this->redirect(['index']);
   }*/





    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/admin/post/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    protected function findModel($id)
    {
        if (($model = Payments::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
