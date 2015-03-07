<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\components;

use common\helpers\StringHelper;
use common\models\Content;
use yii;
use common\models\Meta;
use common\models\Relationship;

class TagComp extends BaseComp{


    public function getTagList(){

        return Meta::find()->where(['type'=>Meta::TYPE_TAG])->asArray()->all();
    }

    public function getTagsWithPostId($postId){

        $tablePrefix=Yii::$app->db->tablePrefix;

        if(empty($postId)){
            return null;
        }

        $post=Content::findOne(['type'=>Content::TYPE_POST,'cid'=>$postId]);
        if(!$post){
            return null;
        }

        return (new yii\db\Query())
            ->select('m.mid,m.name')
            ->from($tablePrefix.'metas m')
            ->leftJoin($tablePrefix.'relationships r','m.mid = r.mid')
            ->where([
                'm.type'=>Meta::TYPE_TAG,
                'r.cid'=>$postId,
            ])
            ->all();
    }

    public function insertPostTags($postId,$tags){

        if(!is_array($tags)){

            return false;
        }

        $this->delTagsWithPostId($postId);//先删除标签
        //插入新标签
        $tagIds=$this->scanTags($tags);
        if($tagIds){
            foreach($tagIds as $v){

                $model=new Relationship();
                $model->cid=$postId;
                $model->mid=$v;
                $model->insert(false);
                //更新标签文章数
                Meta::updateAllCounters(['count'=>1],['mid'=>$v]);
            }
        }

        return true;
    }

    /**
     * 删除文章的标签
     * @param integer $postId
     */
    public function delTagsWithPostId($postId){
        //获取文章标签
        $existTags=$this->getTagsWithPostId($postId);
        //删除标签
        foreach($existTags as $v){
            Relationship::deleteAll(['cid'=>$postId,'mid'=>$v['mid']]);
            //更新标签的文章数
            Meta::updateAllCounters(['count'=>'-1'],['mid'=>$v['mid']]);
        }
    }

    //删除标签
    public function deleteTag($id){

        $model=Meta::findOne(['mid'=>$id,'type'=>Meta::TYPE_TAG]);
        if(!$model){
            return false;
        }
        //删除和文章的关联
        Relationship::deleteAll(['mid'=>$id]);
        //删除分类
        return $model->delete();

    }
    //根据tag获取id
    public function scanTags($inputTags){
        if(!is_array($inputTags)){
            return false;
        }
        $inputTags=array_unique($inputTags);
        $result=[];
        foreach($inputTags as $v){
            if(empty($v)){
                continue;
            }
            $slug=StringHelper::generateCleanStr($v);
            if(!$slug){
                continue;
            }
            $model=Meta::findOne(['type'=>Meta::TYPE_TAG,'name'=>$slug]);
            if($model){
                $result[]=$model->mid;

            }else{
                $meta=new Meta();
                $meta->name=$meta->slug=$slug;
                $meta->type=Meta::TYPE_TAG;
                if($meta->insert(false)){
                    $result[]=$meta->mid;
                }
            }

        }
        return $result;
    }

}