<?php
/**
 * @author: mojifan [<https://github.com/mojifan>]
 */

namespace common\components;

use yii;

class UserComp extends BaseComp{

    private $_userList;


    public function getUserList(){

        if(!$this->_userList){
            $list=\common\models\User::find()->select('uid,name,mail,url,screenName,created,activated,logged,group')->asArray()->all();
            $this->_userList=yii\helpers\ArrayHelper::index($list,'uid');

        }
        return $this->_userList;
    }

    public function getUser($uid){
        $this->getUserList();
        return $this->isUserExist($uid)?$this->_userList[$uid]:null;
    }

    public function getUserScreenName($uid){
        $user=$this->getUser($uid);
        return $user==null?:$user['screenName'];
    }

    public function  isUserExist($uid){
        $this->getUserList();
        return array_key_exists($uid,$this->_userList);
    }

    public function getUserGroupName($group=null){
        $userGroup=\common\models\User::getUserGroup();
        if($group===null){
            return null;
        }else{
            return array_key_exists($group,$userGroup)?$userGroup[$group]:null;
        }
    }

}