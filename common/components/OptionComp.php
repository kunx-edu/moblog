<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\components;

use yii;

class OptionComp extends BaseComp{

    private $_optionList;

    private $cacheKey='option';

    /**
     * 获取设置数组
     * @return array
     */
    public function getOptionList(){
        if($this->_optionList==null){
            $optionList=\common\models\Option::find()->asArray()->all();
            $this->_optionList=yii\helpers\ArrayHelper::map($optionList,'name','value');
        }
        return $this->_optionList;
    }

    /**
     * 更新设置选项
     * @param $data
     */
    public function updateOption($data){
        foreach($data as $k=> $v){
            $optionList=$this->getOptionList();
            if(array_key_exists($k,$optionList)){
                \common\models\Option::updateAll(['value'=>$v],['name'=>$k]);
            }
        }
    }

    /**
     * 获取设置单个值
     * @param $name
     * @return null
     */
    public function getOptionValue($name){
        //缓存中获取
        $optionList=Yii::$app->cache->get($this->cacheKey);
        if($optionList===false){
            $optionList=$this->getOptionList();
            Yii::$app->cache->set($this->cacheKey,$optionList);
        }
        return array_key_exists($name,$optionList)?$optionList[$name]:null;
    }

    /**
     * 清除设置值缓存
     * @return bool
     */
    public function clearOptionCache(){
        return Yii::$app->cache->delete($this->cacheKey);
    }


}