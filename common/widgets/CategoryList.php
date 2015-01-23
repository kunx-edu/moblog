<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\widgets;

use yii;
use yii\helpers\Html;
use common\components\CategoryComp;

class CategoryList extends yii\base\Widget{

    private $_inputStr;

    private $_categoryList=[];


    public $options;

    public function init(){

        parent::init();

        $categoryList=CategoryComp::getInstance()->getAllChildren();

        $this->_inputStr='<ul>';

        if(!empty($categoryList)){
            foreach($categoryList as $v){

                $this->_inputStr.='<li>';
                $this->_inputStr.=Html::a(str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$v['depth']-1).$v['name'],['site/category','id'=>$v['mid']],$this->options);
                $this->_inputStr.='</li>';

            }
        }


        $this->_inputStr.='</ul>';

    }

    public function run(){

        return $this->_inputStr;


    }
}