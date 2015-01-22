<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\widgets;

use yii;
use yii\helpers\Html;
use common\components\CategoryComp;

class CategoryCheckboxList extends yii\base\Widget{

    public $postId;

    private $_inputStr;

    private $_categoryList=[];


    public $options;

    public function init(){

        parent::init();

        $this->options['encodeSpaces']=true;

        $categoryList=CategoryComp::getInstance()->getAllChildren();

        if($this->postId!=null){
            $postCategoryList=CategoryComp::getInstance()->getCategoryWithPostId(intval($this->postId));

            $postIds=yii\helpers\ArrayHelper::getColumn($postCategoryList,'mid');
        }else{
            $postIds=[];
        }

        $this->_inputStr='<div class="form-group">';

        $this->_inputStr.=Html::label('分类');

        foreach($categoryList as $v){

            $this->_inputStr.='<div class="checkbox">';
            $this->_inputStr.=str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$v['depth']-1).Html::checkbox('category[]',in_array($v['mid'],$postIds),['label'=>$v['name'],'value'=>$v['mid']]);
            $this->_inputStr.='</div>';

        }

        $this->_inputStr.='</div>';

    }

    public function run(){

        return $this->_inputStr;


    }
}