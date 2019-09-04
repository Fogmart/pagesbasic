<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = 'Редактирование: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$users = $model->users;
?>
<div class="group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?php if ($users) {?>
        <h2>Участники</h2>
        <ol>
            <?php foreach ($users as $one) {?>
                <li><?=$one->username?>, <?=$one->commentatorName?></li>

            <?php }?>
        </ol>
    <?php }?>

</div>
