<?php
use yii\helpers\Html;
use common\components\Category;
/* @var $this yii\web\View */
/* @var $dataList array */
$this->title = '管理标签';
?>
<div class="meta-index">

    <p>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>名称</th>
            <th>缩略名</th>
            <th>文章数</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach($dataList as $v): ?>
        <tr>
            <td><?=Html::checkbox('mid[]',false,['value'=>$v['mid']])?></td>
            <td>
                <?=Html::a($v['name'],['update','id'=>$v['mid']])?>

            <td><?=$v['slug']?></td>
            <td><?=$v['count']?></td>
            <td>
                <?=Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$v['mid']],[
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
