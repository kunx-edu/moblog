<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="content card">
                <header class="page-header no-author">
                    <h2><?=$model->title;?></h2>
                </header>
                <div>
                    <?=\yii\helpers\Markdown::process($model->text)?>

                </div>
            </div>
        </div>
        <?= $this->render('_right');?>
    </div>
</div>
