<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace backend\controllers;

use common\components\CategoryComp;
use common\components\PostComp;
use common\components\Upload;
use common\models\Content;
use Yii;

use backend\components\BaseController;
use common\models\LoginForm;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\Response;
use yii\web\UploadedFile;


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

    /**
     * 上传文件
     * @return array
     */
    public function actionUpload(){
        Yii::$app->response->format=Response::FORMAT_JSON;

        //error ['err'=>1,'msg'=>'error message']
        //success ['err'=>0,'msg'=>'success message','data'=>['id'=>'','name'=>'','url'=>'','type'=>'','isImage'=>'']]
        $upload=new Upload();
        if($upload->checkFileInfoAndSave()){

            $data=[
                'name'=>Html::encode($upload->originalFileName),
                'url'=>Yii::getAlias('@web/upload/'.$upload->saveRelativePath),
                'type'=>$upload->fileExt,
                'isImage'=>$upload->isImage
            ];

            //保存到数据库
            $content=new Content();
            $content->title=Html::encode($upload->originalFileName);
            $content->slug=\common\helpers\StringHelper::generateCleanStr($upload->originalFileName).'-'.sha1(microtime(true));
            $content->created=time();
            $content->text=json_encode($data);
            $content->type=Content::TYPE_ATTACHMENT;
            $content->save(false);
            $data['id']=$content->cid;
            return [
                'err'=>0,
                'msg'=>'上传成功',
                'data'=>$data
            ];
        }else{
            return ['err'=>1,'msg'=>$upload->error];
        }

    }
}
