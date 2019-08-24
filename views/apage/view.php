<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Тексты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['page/alltext']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>


<div class="col-md-12">
    <p><?=$model->text?></p>
</div>



</div>
