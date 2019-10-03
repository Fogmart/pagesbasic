<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin([
            'options' => [
                        'enctype'=>'multipart/form-data',
                        'id'=>"frm"
            ]
        ]); ?>


    <?= $form->field($model, 'deleted')->hiddenInput() ?>
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


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>

        <?php if ($model->id)
            echo Html::button('Удалить',
                [
                    'class' => 'btn btn-danger',
                    'onClick'=>"(function (  ) { 
                            if (confirm('Удалить запись?')){
                                $('#frm').attr('action', '/page/delete?id=".$model->id."');
                                $('#frm').submit();
                            }
                            })();"
                ]) ?>
    </div>


    <?php ActiveForm::end(); ?>



</div>
