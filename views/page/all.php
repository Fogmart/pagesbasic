<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<?php

/*@var $cats app\models\Category*/

use yii\helpers\Html;
$user = Yii::$app->user->identity;
global $ucatIds, $EditCats;
$ucatIds = $user->catIds;
$EditCats = $user->editCats;


function renderlist($cat, $types){
    global $ucatIds, $EditCats;
    if (in_array($cat->id, $ucatIds)) {

        echo "<li>" . $cat->name;
        if (in_array($cat->id, $EditCats)) echo "   ".Html::a("<i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i>
", ['/page/create/'.$cat->id]);
        if (isset($cat->child)) {
            echo "<ul>";
            foreach ($cat->child as $ch) {
                renderlist($ch, $types);
            }
            echo "</ul>";
        }
        if (in_array('text', $types)) {
            if (isset($cat->pages)) {
                echo "<ul>";
                foreach ($cat->pages as $page) {
                    echo "<li>" . Html::a($page->title, ['page/' . $page->id]) . "</li>";
                }
                echo "</ul>";
            }
        }
        if (in_array('php', $types)) {
            if (isset($cat->pagesPhp)) {
                echo "<ul>";
                foreach ($cat->pagesPhp as $page) {
                    echo "<li>" . Html::a($page->title, ['php/' . $page->id]) . "</li>";
                }
                echo "</ul>";
            }
        }
        echo "</li>";
    } else {
        foreach ($cat->child as $ch) {
            renderlist($ch, $types);
        }
    }
}
?>

<div class="body-content">
    <div class="row">
        <div class="col-md-10">
            <ul>
            <?php
            foreach ($cats as $cat){
                renderlist($cat, $types);
            } ?>
            </ul>
        </div>



</div>
