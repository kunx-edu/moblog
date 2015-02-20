<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理文件';
?>
<div class="content-index">

    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>文件名</th>
            <th>上传者</th>
            <th>所属文章</th>
            <th>发布日期</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($dataList as $v): ?>
            <tr>
                <td><?=Html::checkbox('cid[]',false,['value'=>$v['cid']])?></td>
                <td>
                    <a href="<?=\common\components\MediaComp::getInstance()->parseMediaContent($v['text'])?>" target="_blank"><?=$v['title']?></a>

                <td><?=\common\components\UserComp::getInstance()->getUserScreenName($v['authorId'])?></td>

                <td><?=$v['parent']?></td>


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
