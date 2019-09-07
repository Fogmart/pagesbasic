<?php

use app\models\PagesPhp;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PagesPhp */

$this->title = "Личный кабинет";
\yii\web\YiiAsset::register($this);
?>
<div class="pages-php-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $html = file_get_contents(\yii\helpers\Url::home(true).$model->homePageUrl);
    ?>
    <div>
        <?=$html?>
    </div>


</div>
