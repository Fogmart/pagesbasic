<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategoriesPhp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-php-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parid')
        ->dropDownList(
            \yii\helpers\ArrayHelper::map($model->getOtherCats(), "id", "name"),
            ['prompt'=>''])
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
