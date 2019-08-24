<?php

/*@var $cats app\models\Category*/

use yii\helpers\Html;
$user = Yii::$app->user->identity;
$ucatIds = $user->catIds;
function renderlist($cat, $types, $ucatIds){

    if (in_array($cat->id, $ucatIds)) {

        echo "<li>" . $cat->name;
        if (isset($cat->child)) {
            echo "<ul>";
            foreach ($cat->child as $ch) {
                renderlist($ch, $types, $ucatIds);
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
            renderlist($ch, $types, $ucatIds);
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
                renderlist($cat, $types, $ucatIds);
            } ?>
            </ul>
        </div>



</div>
