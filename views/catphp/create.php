<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriesPhp */

$this->title = 'Добавление категории страниц';
$this->params['breadcrumbs'][] = ['label' => 'Categories Phps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-php-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
