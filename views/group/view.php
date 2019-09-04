<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$users = $model->users;
?>
<div class="group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
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
