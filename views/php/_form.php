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

    <?= $form->field($model, 'text')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'phpurl')->textInput() ?>


    <?= $form->field($model, 'catid')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), "id", "name"), ['prompt'=>'']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
