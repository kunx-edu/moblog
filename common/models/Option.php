<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%options}}".
 *
 * @property string $name
 * @property integer $user
 * @property string $value
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','user','value'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'user' => 'User',
            'value' => 'Value',
        ];
    }
}
