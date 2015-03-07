<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\components;
use yii;
use common\models\Content;
class MediaComp extends BaseComp{


    private $_currentMediaListPost;

    public function getMediaList($offset,$limit){
        $whereArr=['type'=>Content::TYPE_ATTACHMENT];

        return Content::find()->select('cid,title,text,authorId,created,parent')->where($whereArr)->orderBy('cid desc')->offset($offset)->limit($limit)->asArray()->all();
    }

    public function getMediaCount(){
        $whereArr=['type'=>Content::TYPE_ATTACHMENT];
        return Content::find()->where($whereArr)->count();
    }

    public function parseMediaContent($jsonContent,$key='url'){
        $mediaArr=json_decode($jsonContent,true);
        return $mediaArr[$key];

    }

    public function insertPostMedia($postId,$media){
        if(!is_array($media)){

            return false;
        }
        $media=array_unique($media);
        foreach($media as $v){
            $model=Content::findOne([
                'type'=>Content::TYPE_ATTACHMENT,
                'cid'=>$v,
            ]);

            if(!$model||$model->parent!=0){
                continue;
            }
            $model->parent=intval($postId);
            $model->update(false);
        }
        return true;

    }

    public function getMediaWithPostId($postId){
        $whereArr=[
            'type'=>Content::TYPE_ATTACHMENT,
            'parent'=>$postId
        ];

        return Content::find()->select('cid,title,text,authorId,created,parent')->where($whereArr)->orderBy('cid desc')->asArray()->all();
    }

    public function delMediaWithPostId($postId){
        Content::deleteAll(['type'=>Content::TYPE_ATTACHMENT,'parent'=>$postId]);
    }

}