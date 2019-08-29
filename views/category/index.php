<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
        'itemOptions'=>[

        ]
    ]);


    ?>

</div>

<script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

<script>
    $(function () {

        $.each($(".dd3-content"), function (i,e) {
            var id = $(this).closest('.dd-item').attr("data-id")
            $(this)
                .append( '('+id+')')
                .append(
                $("<a>")
                    .attr("href", "/category/update?id="+id)
                    .html("<i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i>\n")
                    .css("margin-left", "50px")
            )

        })
    })
</script>
