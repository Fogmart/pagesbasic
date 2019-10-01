<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тексты';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .deleted{
        background: #b21f2d !important;
    }
</style>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            [
                'attribute' => 'text',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->text, 100);
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->deleted == 1) return ['class'=>'deleted'];
            return [];
        }
    ]); ?>

    <?php Pjax::end(); ?>

</div>
