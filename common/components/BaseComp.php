<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */
namespace common\components;

class BaseComp extends  \yii\base\Component{

    protected  static $_instance;

    /**
     * @return CategoryComp|PostComp|TagComp|UserComp|PageComp|OptionComp
     */
    public static function getInstance()
    {
        $class=get_called_class();

        if(!isset(self::$_instance[$class]))
        {

            self::$_instance[$class] = new $class;
        }
        return self::$_instance[$class];

    }
}