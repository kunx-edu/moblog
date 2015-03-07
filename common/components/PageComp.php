<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\components;


use yii;
use common\models\Content;

class PageComp extends BaseComp{


    public function getPageList($offset,$limit,$isAllStatus=true){
        $whereArr=['type'=>Content::TYPE_PAGE];
        if(!$isAllStatus){
            $whereArr['status']=Content::STATUS_PUBLISH;
        }
        return Content::find()->select('cid,slug,title,authorId,created,status,commentsNum')->where($whereArr)->orderBy('cid desc')->offset($offset)->limit($limit)->asArray()->all();
    }

    public function getPageCount($isAllStatus=true){
        $whereArr=['type'=>Content::TYPE_PAGE];
        if(!$isAllStatus){
            $whereArr['status']=Content::STATUS_PUBLISH;
        }
        return Content::find()->where($whereArr)->count();
    }

    public function allPublishedPageList(){
        return Content::find()->select('cid,slug,title')->where(['type'=>Content::TYPE_PAGE,'status'=>Content::STATUS_PUBLISH])->orderBy('order desc')->asArray()->all();
    }


    public function deletePage($cid){

        $model=Content::findOne(['cid'=>$cid,'type'=>Content::TYPE_PAGE]);
        if(!$model){
            return false;
        }
        //删除附件
        MediaComp::getInstance()->delMediaWithPostId($cid);
        return $model->delete();
    }





}