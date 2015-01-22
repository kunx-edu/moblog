<?php
use yii\helpers\Html;
use common\helpers\DateTimeHelper;
/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>
<div class="container">
<div class="row">
<div class="col-md-9">
<div class="content">
    <?php if(isset($category)):?>
    <article class="thread thread-card">
        <h1>分类 <?=$category['name'] ?> 下的文章</h1>
        </article>
    <?php endif; ?>
    <?php foreach($postList as $v): ?>
<article class="thread thread-card">
    <header>
        <div class="time-label">
            <span class="year"><?=DateTimeHelper::getYear($v['created'])?></span>
            <span style="display:block"><?=DateTimeHelper::getMonth($v['created'])?></span>
            <span style="display:block"><?=DateTimeHelper::getDay($v['created'])?></span>
        </div>
        <h3 class="thread-title">
            <?=Html::a($v['title'],['post','id'=>$v['cid']])?>
        </h3>
        <div class="thread-meta">
            <a target="_blank" href="javascript:;" rel="author">
                <?=\common\components\UserComp::getInstance()->getUserScreenName($v['authorId'])?>
            </a>

            <ul class="blog-category">

                <?php
                $postCategoryList=\common\components\CategoryComp::getInstance()->getCategoryWithPostId($v['cid']);
                foreach($postCategoryList as $val):
                ?>
                <li><?=Html::a($val['name'],['site/category','id'=>$val['mid']])?></li>
                <?php endforeach; ?>

            </ul>
        </div>
        <!--<a target="_blank" href="" rel="author" class="avatar avatar-50"><img alt="" src=""></a>-->
    </header>
    <div class="clearfix"></div>
    <div class="markdown-body">
        <?=\yii\helpers\Markdown::process($v['text'])?>
    </div>
    <div class="thread-footer">
        <?=Html::a('阅读原文',['post','id'=>$v['cid']],['class'=>'ds-thread-bevel'])?>
    </div>
</article>
    <?php endforeach; ?>
    <div class="pagination">
        <?=\yii\widgets\LinkPager::widget([
            'pagination'=>$pages,
            'options'=>['class'=>''],
        ])?>
    </div>
</div>
</div>

    <?= $this->render('_right');?>

</div>
</div>
