<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
    $this->title = "Редактирование своей информации";
?>
<div class="user-form">
    <?php $form = ActiveForm::begin();?>
    <div class="row">
        <div class="col-md-4">
            Имя пользователя: <b><?=$model->username?></b>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>