<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理用户';
?>
<div class="user-index">

    <p>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>用户名</th>
            <th>昵称</th>
            <th>电子邮件</th>
            <th>用户组</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($dataList as $v): ?>
            <tr>
                <td><?=Html::checkbox('uid[]',false,['value'=>$v['uid']])?></td>
                <td><?=Html::a($v['name'],['update','id'=>$v['uid']])?></td>
                <td><?=$v['screenName']?></td>

                <td><?=$v['mail']?></td>
                <td><?=\common\components\UserComp::getInstance()->getUserGroupName($v['group'])?></td>
                <td>
                    <?=Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$v['uid']],[
                        'title'=>'删除',
                        'data'=>[
                            'pjax'=>0,
                            'method'=>'post',
                            'confirm'=>'您确定要删除此项吗？',
                        ]
                    ])?>

                </td>
            </tr>
        <?php endforeach; ?>


        </tbody>
    </table>

</div>
