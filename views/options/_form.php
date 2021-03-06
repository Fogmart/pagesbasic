<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Options */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="options-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'basecat')->textInput() ?>

    <?= $form->field($model, 'homeurl')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\PagesLk::find()->all(), "id", "title"),
        ['prompt'=>'']

    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
