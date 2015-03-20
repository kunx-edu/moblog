<?php

namespace backend\controllers;

use backend\components\BaseController;
use common\components\MediaComp;
use Yii;
use common\models\Content;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
/**
 * MediaController implements the CRUD actions for Content model.
 */
class MediaController extends BaseController
{

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pages=new Pagination([
            'totalCount'=>MediaComp::getInstance()->getMediaCount(),
        ]);
        $dataList=MediaComp::getInstance()->getMediaList($pages->offset,$pages->limit);
        return $this->render('index',['dataList'=>$dataList,'pages'=>$pages]);
    }



    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne(['cid'=>$id,'type'=>Content::TYPE_ATTACHMENT])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
