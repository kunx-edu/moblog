<?php

namespace common\models;

use common\helpers\StringHelper;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%contents}}".
 *
 * @property integer $cid
 * @property string $title
 * @property string $slug
 * @property integer $created
 * @property integer $modified
 * @property string $text
 * @property integer $order
 * @property integer $authorId
 * @property string $template
 * @property string $type
 * @property string $status
 * @property string $password
 * @property integer $commentsNum
 * @property string $allowComment
 * @property string $allowPing
 * @property string $allowFeed
 * @property integer $parent
 */
class Content extends \yii\db\ActiveRecord
{
    const TYPE_POST='post';
    const TYPE_PAGE='page';
    const TYPE_ATTACHMENT='attachment';

    const STATUS_PUBLISH='publish';
    const STATUS_HIDDEN='hidden';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug'], 'string', 'max' => 200],
            [['slug'],'filter','filter'=>function($value){
               return StringHelper::generateCleanStr($value);
            }],
            [['slug'], 'unique'],
            [['title'],'default','value'=>function($model,$attribute){
                $title='未命名文档';
                if($model->type==self::TYPE_PAGE){
                    $title='未命名页面';
                }
                return $title;
            }],
            [['title'],'filter','filter'=>function($value){
                return Html::encode($value);
            }],
            [['order','allowComment', 'allowPing', 'allowFeed'],'filter','filter'=>function($value){
                return intval($value);
            }],
            [['status'],'filter','filter'=>function($value){
                return in_array($value,[self::STATUS_PUBLISH,self::STATUS_HIDDEN])?$value:self::STATUS_PUBLISH;
            }],
            [['created'],'filter','filter'=>function($value){
                if($value==''){
                    return time();
                }else{
                    return strtotime($value);
                }
            }],
            [['text', 'modified', 'authorId', 'commentsNum', 'parent','type','template', 'password'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'title' => '标题',
            'slug' => '缩略名',
            'created' => '发布日期',
            'modified' => '修改日期',
            'text' => '内容',
            'order' => '页面顺序',
            'authorId' => '作者ID',
            'template' => '模板',
            'type' => '类型',
            'status' => '公开度',
            'password' => '密码',
            'commentsNum' => '评论数',
            'allowComment' => '允许评论',
            'allowPing' => '允许被引用',
            'allowFeed' => '允许在聚合中出现',
            'parent' => 'Parent',
        ];
    }

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){

            if($insert){

                $this->authorId=Yii::$app->user->identity->getId();
                $this->commentsNum=0;
            }else{
                $this->authorId=$this->getOldAttribute('authorId');
            }

            $this->modified=time();

            return true;
        }else{
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes){

        //更新slug
        if($this->slug==''){
            $this->slug=$this->cid;
            $this->update(false);
        }
    }



}
