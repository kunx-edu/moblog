<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章';
?>
<div class="content-index">

    <p>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th>日期</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($dataList as $v): ?>
            <tr>
                <td><?=Html::checkbox('cid[]',false,['value'=>$v['cid']])?></td>
                <td>
                    <?=Html::a($v['title'],['update','id'=>$v['cid']])?>

                <td><?=\common\components\UserComp::getInstance()->getUserScreenName($v['authorId'])?></td>
                <td><?=\common\components\PostComp::getInstance()->getPostCategoryName($v['cid'])?></td>
                <td><?=Yii::$app->formatter->asDatetime($v['created'])?></td>
                <td>
                    <?=Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$v['cid']],[
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
    <?=\yii\widgets\LinkPager::widget([
        'pagination'=>$pages,
    ])?>

</div>
