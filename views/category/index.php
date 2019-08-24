<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $all \app\models\Category */

$this->title = 'Категории статей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <ul>
        <?php foreach ($all as  $one){?>
            <li><?=$one->name?></li>
        <?php } ?>
    </ul>


<?php

    echo \slatiusa\nestable\Nestable::widget([
        'type' => \slatiusa\nestable\Nestable::TYPE_WITH_HANDLE,
        'query' => \app\models\Category::find()->where(['parid'=>null]),
        'modelOptions' => [
            'name' => 'name'
        ],
        'pluginEvents' => [
            'change' => 'function(e) {}',
        ],
        'pluginOptions' => [
            'maxDepth' => 7,
        ],
    ]);


    ?>


</div>
