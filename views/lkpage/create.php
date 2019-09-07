<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PagesLk */

$this->title = 'Добавление страницы личного кабинета';
$this->params['breadcrumbs'][] = ['label' => 'Страницы личного кабинета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pages-lk-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
