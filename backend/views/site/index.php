<?php
/* @var $this yii\web\View */

$this->title = '网站概要';
?>
<div class="row">
    <div class="col-lg-12">

        <div class="panel panel-default">
            <div class="panel-body">
                <p class="lead">目前有 <em><?=$postCount?></em> 篇文章, 并有 <em>0</em> 条关于你的评论在 <em><?=$categoryCount?></em> 个分类中.</p>
                <p class="lead">点击下面的链接快速开始:</p>
                <div>

                    <a href="<?=Yii::$app->urlManager->createUrl('post/create')?>" class="btn btn-primary">撰写新文章</a>
                    <a href="<?=Yii::$app->urlManager->createUrl('theme')?>" class="btn btn-primary">更换外观</a>
                    <a href="<?=Yii::$app->urlManager->createUrl('plugin')?>" class="btn btn-primary">插件管理</a>
                    <a href="<?=Yii::$app->urlManager->createUrl('option')?>" class="btn btn-primary">系统设置</a>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">最近发布的文章</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach($recentPublishedPost as $v): ?>
                    <li>
                        <span>10.31</span>
                        <a href="http://typecho.m.com/index.php/archives/3/" class="title"><?=$v['title'];?></a>
                    </li>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">最近得到的回复</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>
                        <span>11.5</span>
                        <a href="http://typecho.m.com/index.php/archives/1/#comment-6" class="title"><a href="http://www.typecho.org" rel="external nofollow">admin</a></a>:
                        hiufiof                        </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">官方最新日志</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>读取中...</li>
                </ul>
            </div>
        </div>
    </div>
</div>