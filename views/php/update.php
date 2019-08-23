<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PagesPhp */

$this->title = 'Update Pages Php: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Pages Phps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pages-php-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
