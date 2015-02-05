<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Content */
$this->title = $model->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="content">
                <div class="card thread-card">
                    <header class="page-header with-author">
                        <h2><?=$model->title;?></h2>
                        <div class="thread-meta">
                            <a target="_blank" href="javascript:;" rel="author">
                                <?=\common\components\UserComp::getInstance()->getUserScreenName($model->authorId)?>
                            </a>
                            发表于 <time><?=Yii::$app->formatter->asDate($model->created)?></time>
                        </div>

                    </header>
                    <div class="inner markdown-body">
                        <?=\yii\helpers\Markdown::process($model->text)?>
                    </div>
                    <div>
                        Tag:
                        <?php
                        $postTags=\common\components\TagComp::getInstance()->getTagsWithPostId($model->cid);
                        foreach($postTags as $val):
                            ?>
                            <?=Html::a($val['name'],['site/tag','id'=>$val['mid']],['class'=>'label label-default'])?>
                        <?php endforeach; ?>
                    </div>
                    <!--分享插件-->
                </div>
            </div>
        </div>
        <?= $this->render('_right');?>
    </div>
</div>
