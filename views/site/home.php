<?php

use app\models\PagesPhp;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PagesPhp */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['php/allphp']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pages-php-view">

    <iframe src="<?=$model->fullPhpUrl?>" name="mainframe" width="<?=$model->width?>" height="<?=$model->height?>"> </iframe>


</div>
