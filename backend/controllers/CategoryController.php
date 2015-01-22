<?php

namespace backend\controllers;

use Yii;
use common\models\Meta;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;

use common\components\CategoryComp;

/**
 * CategoryController implements the CRUD actions for Meta model.
 */
class CategoryController extends BaseController
{

    /**
     * Lists all Meta models.
     * @return mixed
     */
    public function actionIndex($parent=0)
    {

        $parent=intval($parent);
        if($parent!=0&&!CategoryComp::getInstance()->isCategoryExist($parent)){

            throw new NotFoundHttpException;
        }

        return $this->render('index',['dataList'=>CategoryComp::getInstance()->getSubCategoryList($parent)]);
    }


    /**
     * Creates a new Meta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent=0)
    {

        $model = new Meta();

        $model->parent=intval($parent);


        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->type=Meta::TYPE_CATEGORY;
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

        CategoryComp::getInstance()->deleteCategory($id);

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
        if (($model = Meta::findOne(['mid'=>$id,'type'=>Meta::TYPE_CATEGORY])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
