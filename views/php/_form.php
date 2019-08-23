<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PagesPhp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pages-php-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'whncrt')->textInput() ?>

    <?= $form->field($model, 'phpurl')->textInput() ?>

    <?= $form->field($model, 'url')->textInput() ?>

    <?= $form->field($model, 'catid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
