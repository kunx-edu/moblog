<?php

namespace backend\controllers;

use Yii;
use common\models\Meta;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;

use common\components\TagComp;

/**
 * CategoryController implements the CRUD actions for Meta model.
 */
class TagController extends BaseController
{

    /**
     * Lists all Meta models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index',['dataList'=>TagComp::getInstance()->getTagList()]);
    }


    /**
     * Creates a new Meta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent=0)
    {

        $model = new Meta();


        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->type=Meta::TYPE_TAG;
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Meta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())&&$model->save()){
                return $this->redirect(['index']);
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Meta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id);
        TagComp::getInstance()->deleteTag($id);

        $this->redirect(['index']);
    }

    /**
     * Finds the Meta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Meta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Meta::findOne(['mid'=>$id,'type'=>Meta::TYPE_TAG])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
