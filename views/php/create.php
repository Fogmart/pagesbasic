<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PagesPhp */

$this->title = 'Create Pages Php';
$this->params['breadcrumbs'][] = ['label' => 'Pages Phps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-php-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
