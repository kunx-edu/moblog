<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\components;

use yii;
use common\models\Meta;
use common\models\Relationship;

class TagComp extends BaseComp{


    public function getTagList(){

        return Meta::find()->where(['type'=>Meta::TYPE_TAG])->asArray()->all();
    }

    //删除分类
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

}