<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;


/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="page-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype'=>'multipart/form-data']
        ]); ?>
    <?= $form->field($model, 'deleted')->hiddenInput(['value'=>0]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'text')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'plugins' => [
                    'clips',
                    'fullscreen',
                ],
                'clips' => [
                    ['Lorem ipsum...', 'Lorem...'],
                    ['red', '<span class="label-red">red</span>'],
                    ['green', '<span class="label-green">green</span>'],
                    ['blue', '<span class="label-blue">blue</span>'],
                ],
                'imageUpload' => \yii\helpers\Url::to(['/default/image-upload']),
                'plugins' => [
                    'imagemanager',
                ],
            ],
        ]);
        ?>

    <?= $form->field($model, 'catid')->dropDownList(
            \yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), "id", "name"),
            [\app\models\Category::defCat()->id=>\app\models\Category::defCat()->name]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>
