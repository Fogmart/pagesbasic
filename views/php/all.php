<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<?php

/*@var $cats app\models\Category*/

use yii\helpers\Html;
$user = Yii::$app->user->identity;
global $ucatIds;
$ucatIds = $user->catphpIds;



function renderlist($cat){
    global $ucatIds, $EditCats;
    if (in_array($cat->id, $ucatIds)) {

       echo "<li>" . $cat->name;

        if (isset($cat->child)) {
            echo "<ul>";
            foreach ($cat->child as $ch) {
                renderlist($ch);
            }
            echo "</ul>";
        }
        if (isset($cat->pagesPhp)) {
            echo "<ul>";
            foreach ($cat->pagesPhp as $page) {
                echo "<li>" . Html::a($page->title, ['php/' . $page->id]) . "</li>";
            }
            echo "</ul>";
        }
        echo "</li>";
    } else {
        foreach ($cat->child as $ch) {
            renderlist($ch);
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
                renderlist($cat);
            } ?>
            </ul>
        </div>



</div>
