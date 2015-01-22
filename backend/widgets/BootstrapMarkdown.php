<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace backend\widgets;

use backend\assets\BootstrapMarkdownAsset;
use yii;
use yii\helpers\Html;
class BootstrapMarkdown extends yii\base\Widget{


    public $model;

    public $attribute;

    public $language;

    public $options;


    public function init(){

        $this->options['data-provide']='markdown';
        if(!$this->language){
            $this->language='en';
        }
    }

    public function run(){

        BootstrapMarkdownAsset::register($this->view);
        return Html::activeTextarea($this->model,$this->attribute,$this->options);
    }
}