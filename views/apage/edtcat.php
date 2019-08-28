<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $pagelst app\models\Page */

$this->title = 'Редактирование категории ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table>
        <tr>
            <th> Заголовок <th>
        </tr>
        <?php foreach ($pagelst as $page){?>
            <tr>
                <td> <?=$page->title?> <td>
            </tr>
        <?php } ?>

    </table>

</div>

