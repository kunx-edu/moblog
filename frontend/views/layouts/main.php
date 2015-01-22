<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(\common\helpers\SiteHelper::getFrontendTitle($this->title)) ?></title>

    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <header class="navbar navbar-inverse navbar-fixed-top" id="header">
        <div role="navigation" class="container">
            <div class="row">
                <div class="col-xs-2 navbar-header"><a href="<?=Yii::$app->homeUrl;?>" class="navbar-brand"><?=Yii::$app->name;?></a></div>

                <ul class="navbar-nav pull-right">
                    <li class="active">
                        <a href="<?=Yii::$app->homeUrl;?>">首页</a>
                    </li>
                    <?php
                    $pageList=\common\components\PageComp::getInstance()->allPublishedPageList();

                    $mainPageList=$pageList;
                    $dropPageList=[];
                    if(count($pageList)>5){
                        $mainPageList=array_slice($pageList,0,5);
                        $dropPageList=array_slice($pageList,5,count($pageList)-5);
                    }

                    foreach($mainPageList as $v): ?>
                    <li>
                        <?=Html::a($v['title'],['page','id'=>$v['cid']])?>
                    </li>
                    <?php endforeach; ?>
                    <?php if(count($dropPageList)>0): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">更多<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach($dropPageList as $val): ?>
                            <li>
                                <?=Html::a($val['title'],['page','id'=>$val['cid']])?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </header>

        <div class="container">
        <?= $content ?>
        </div>

    <footer id="footer">
        <div class="container">
        <p class="pull-left">&copy; <?=Yii::$app->name;?> <?= date('Y') ?></p>
        <p class="pull-right">
            <?=Yii::powered()?>
        </p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
