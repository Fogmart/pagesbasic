<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PagesLk */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages Lks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pages-lk-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $html = file_get_contents(\yii\helpers\Url::home(true).$model->url);
    ?>
    <div>
        <?=$html?>
    </div>

</div>
