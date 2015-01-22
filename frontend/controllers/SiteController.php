<?php
namespace frontend\controllers;

use common\components\CategoryComp;
use common\models\Content;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use common\components\PostComp;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{


    /**
     * @inheritdoc
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

    public function actionIndex()
    {
        $pages=new Pagination([
            'totalCount'=>PostComp::getInstance()->getPostCount(false),
        ]);
        $postList=PostComp::getInstance()->getPostList($pages->offset,$pages->limit,false,true);
        return $this->render('list',['postList'=>$postList,'pages'=>$pages]);
    }

    public function actionPost($id=0){
        $model=Content::findOne(['cid'=>$id,'type'=>Content::TYPE_POST,'status'=>Content::STATUS_PUBLISH]);
        if(!$model){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->render('post',['model'=>$model]);


    }

    public function actionPage($id=0){
        $model=Content::findOne(['cid'=>$id,'type'=>Content::TYPE_PAGE,'status'=>Content::STATUS_PUBLISH]);
        if(!$model){
            throw new NotFoundHttpException('页面不存在');
        }
        return $this->render('page',['model'=>$model]);

    }

    public function actionCategory($id=0){
        if(!CategoryComp::getInstance()->isCategoryExist($id)){
            throw new NotFoundHttpException('页面不存在');
        }
        $pages=new Pagination([
            'totalCount'=>PostComp::getInstance()->getPostCountByCategory($id)
        ]);
        $postList=PostComp::getInstance()->getPostByCategory($id,$pages->offset,$pages->limit);
        return $this->render('list',[
            'postList'=>$postList,
            'pages'=>$pages,
            'category'=>CategoryComp::getInstance()->getSingleCategory($id)]);
    }


}
