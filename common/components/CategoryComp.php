<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\components;

use yii;
use yii\helpers\Html;
use common\models\Meta;
use common\models\Relationship;
class CategoryComp extends BaseComp{


    private $_allCategoryList=[];

    private $_parentIdList=[];

    private $_childrenIdList=[];


    public  function __construct(){
        parent::__construct();

        $allList=Meta::find()->where(['type'=>Meta::TYPE_CATEGORY])->asArray()->all();


        //循环获取层次关系
        foreach($allList as $v){

            $this->_allCategoryList[$v['mid']]=$v;//将id作为key

            if(!array_key_exists($v['mid'],$this->_childrenIdList)){
                $this->_childrenIdList[$v['mid']]=[];
            }
            $this->_childrenIdList[$v['parent']][]=$v['mid'];
            $this->_parentIdList[$v['mid']]=$v['parent'];

        }


    }


    public function getAllChildren(){
        $list=[];
        if(!empty($this->_childrenIdList)){
            foreach($this->_childrenIdList[0] as $v){
                $list=array_merge($list,$this->getChildren($v));
            }
            return $list;
        }

    }

    public function getChildren($parent,$depth=1){
        $parent=intval($parent);
        if($parent!=0&&!$this->isCategoryExist($parent)){
            return [];
        }

        $cate=$this->_allCategoryList[$parent];
        $cate['depth']=$depth;
        $list[]=$cate;

        foreach($this->_childrenIdList[$parent] as $v){
            $list=array_merge($list,$this->getChildren($v,$depth+1));
        }
        return $list;
    }


    //获取所有父类
    public function getParents($child){

        $child=intval($child);
        if($child!=0&&!$this->isCategoryExist($child)){
            return [];
        }
        $parent=array_key_exists($child,$this->_parentIdList)?$this->_parentIdList[$child]:0;
        $list=[];
        while($parent>0){
            $list[]=$this->isCategoryExist($parent)?$this->_allCategoryList[$parent]:[];
            $parent=array_key_exists($parent,$this->_parentIdList)?$this->_parentIdList[$parent]:0;
        }

        return $list;
    }

    //获取父类
    public function getParent($child){
        $parent=array_key_exists($child,$this->_parentIdList)?$this->_parentIdList[$child]:0;
        if($parent>0){
            return $this->isCategoryExist($parent)?$this->_allCategoryList[$parent]:null;
        }else{
            return null;
        }
    }

    /**
     * 根据id判断分类是否存在
     * @param string $id 分类id
     * @return bool
     */
    public function isCategoryExist($id){

        return array_key_exists($id,$this->_allCategoryList);

    }

    /**
     * 获取直接子分类列表
     * @param $parent
     * @return array
     */
    public function getSubCategoryList($parent){
        $parent=intval($parent);
        if($parent!=0&&!$this->isCategoryExist($parent)){
            return [];
        }
        $list=[];
        if(!empty($this->_childrenIdList)){
            foreach($this->_childrenIdList[$parent] as $v){
                $list[$v]=$this->_allCategoryList[$v];
            }
        }
        return $list;

    }

    //直接子分类数量
    public function subCategoryCount($parent){
        $parent=intval($parent);
        if($parent!=0&&!$this->isCategoryExist($parent)){
            return 0;
        }
        return count($this->_childrenIdList[$parent]);
    }

    //显示子分类链接还是创建链接
    public function displayCategoryCountOrCreateLink($parent){

        $count=$this->subCategoryCount($parent);
        if($count==0){
            return Html::a('新增',['category/create','parent'=>$parent]);
        }else{
            return Html::a($count.'个分类',['category','parent'=>$parent]);
        }
    }


    //删除分类
    public function deleteCategory($id){

        $model=Meta::findOne(['mid'=>$id,'type'=>Meta::TYPE_CATEGORY]);
        if(!$model){
            return false;
        }
        //修改直接子类的父级id
        Meta::updateAll(['parent'=>$model->parent],'parent=:parent AND type=:type',[':parent'=>$id,':type'=>Meta::TYPE_CATEGORY]);

        //删除和文章的关联
        Relationship::deleteAll(['mid'=>$id]);
        //删除分类
        return $model->delete();

    }


    //获取文章所属分类
    public function getCategoryWithPostId($cid){

        $list=Relationship::findAll(['cid'=>$cid]);
        $categoryArr=[];
        foreach($list as $v){
            if($this->isCategoryExist($v->mid)){
                $categoryArr[]=$this->_allCategoryList[$v->mid];
            }
        }
        return $categoryArr;
    }

    public function insertPostCategory($cid,$category){
        if(!is_array($category)){

            return false;
        }
        //删除文章的关联分类
        Relationship::deleteAll(['cid'=>$cid]);

        //todo:更新分类文章数量

        foreach($category as $v){
            if(!$this->isCategoryExist($v)){
                continue;
            }
            $model=new Relationship();
            $model->cid=$cid;
            $model->mid=$v;
            $model->insert(false);
        }
        return true;

    }

    public function getCategoryCount(){
        return Meta::find()->where(['type'=>Meta::TYPE_CATEGORY])->count();
    }

    public function getSingleCategory($mid){
        $cate=[];
        if($this->isCategoryExist($mid)){
            $cate=$this->_allCategoryList[$mid];
        }
        return $cate;
    }









}