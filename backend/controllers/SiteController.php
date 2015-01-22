<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\controllers;

use common\components\CategoryComp;
use common\components\PostComp;
use Yii;

use backend\components\BaseController;
use common\models\LoginForm;


/**
 * 控制台
 * @package backend\controllers
 */
class SiteController extends BaseController
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


    /**
     * 概要
     * @return string
     */
    public function actionIndex()
    {
        $recentPublishedPost=PostComp::getInstance()->recentPublishedPost(10);
        $postCount=PostComp::getInstance()->getPostCount(false);
        $categoryCount=CategoryComp::getInstance()->getCategoryCount();
        //todo: 评论数量 最新回复 官方日志
        return $this->render('index',[
            'recentPublishedPost'=>$recentPublishedPost,
            'postCount'=>$postCount,
            'categoryCount'=>$categoryCount,
        ]);
    }

    /**
     * 个人设置
     * @return string
     */
    public function actionProfile(){
        return $this->render('profile');
    }


    /**
     * 登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 退出
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
