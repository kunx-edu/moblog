<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\models;

use common\components\Option;
use common\components\OptionComp;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * 基本设置表单
 */
class OptionGeneralForm extends Model
{
    public $title;
    public $description;
    public $keywords;


    public function init(){
        $optionList=OptionComp::getInstance()->getOptionList();
        $this->title=$optionList['title'];
        $this->description=$optionList['description'];
        $this->keywords=$optionList['keywords'];

    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description','keywords'], 'required'],
            [['title', 'description','keywords'], 'filter','filter'=>function($value){
                return Html::encode($value);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => '站点名称',
            'description' => '站点描述',
            'keywords'=>'关键词',
        ];
    }

    public function saveForm(){

        if(!$this->validate()){
            return false;
        }

        OptionComp::getInstance()->updateOption(ArrayHelper::toArray($this));
        return true;
    }
}
