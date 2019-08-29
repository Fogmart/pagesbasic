<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use rmrevin\yii\module\Comments;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['page/alltext']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="col-md-11">
        <p><?= $model->text ?></p>
    </div>
    <div class="col-md-1">
        <?= \yii\bootstrap\Html::a('Изменить',
            ['page/update', 'id' => $model->id],
            ['class' => 'btn btn-success']) ?>
    </div>


</div>

<?php if ($mayComment) {?>
    <div style="border-top: solid;margin-top: 85px;">
        <?= Comments\widgets\CommentListWidget::widget([
            'entity' => (string) 'page'.$model->id,
        ]);?>
    </div>
<?php }?>