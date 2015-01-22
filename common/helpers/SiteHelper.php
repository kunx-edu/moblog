<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\helpers;

use yii;
class SiteHelper{

    public static function getBackendTitle($title){
        return $title==null||$title==''?Yii::$app->name:$title.'-'.Yii::$app->name;
    }

    public static function getFrontendTitle($title){
        return $title==null||$title==''?Yii::$app->name:$title.'-'.Yii::$app->name;
    }

    public static function getKeywords(){

    }

    public static function getDescription(){

    }

    public static function getFrontendNav(){

    }

}