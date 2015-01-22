<?php
use yii\helpers\Html;
use common\components\Category;
/* @var $this yii\web\View */
/* @var $dataList array */
$this->title = '管理分类';
?>
<div class="meta-index">

    <div class="btn-group">
        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
            选中项 <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="#">删除</a></li>
            <li><a href="#">更新</a></li>
        </ul>

    </div>
        <?= Html::a('新增', ['create'], ['class' => 'btn btn-success']) ?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>名称</th>
            <th>子分类</th>
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

            <td><?=\common\components\CategoryComp::getInstance()->displayCategoryCountOrCreateLink($v['mid'])?></td>
            <td><?=$v['slug']?></td>
            <td><?=$v['count']?></td>
            <td>
                <?=Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete','id'=>$v['mid']],[
                    'title'=>'删除',
                    'data'=>[
                        'pjax'=>0,
                        'method'=>'post',
                        'confirm'=>'您确定要删除此分类吗？其下面所有文章都会被删除,子分类及文章不会被删除',
                    ]
                ])?>

            </td>
        </tr>
        <?php endforeach; ?>


        </tbody>
    </table>

</div>
