<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PagesPhp */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['php/allphp']];
$this->params['breadcrumbs'][] = $this->title;


\yii\web\YiiAsset::register($this);
?>
<div class="pages-php-view">
    <input id="minw" type="hidden" value="<?=$model->min_width?>">
    <input id="minw" type="hidden" value="<?=$model->min_width?>">
    <input id="w" type="hidden" value="<?=$model->width?>">
    <input id="h" type="hidden" value="<?=$model->height?>">

    <iframe src="<?=$model->fullPhpUrl?>"
            id="mainframe"
            name="mainframe"
            width="<?=$model->width?>" height="<?=$model->height?>"> </iframe>


</div>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>
<script>
$(function () {
    var width = parseInt(screen.width) * 0.75
    var height = parseInt(screen.height)

    var min_width = ($("#minw").val())
    var min_height = ($("#minh").val())

    var max_width = ($("#w").val())
    var max_height = ($("#h").val())

    if (min_width != "") if ( width < parseInt(min_width)) width = min_width
    if (max_width != "") if ( width > parseInt(max_width)) width = max_width

    if (min_height != "") if ( height < parseInt(min_height)) height = min_height
    if (max_height != "") if ( height > parseInt(max_height)) height = max_height
    $("#mainframe").attr("width", width).attr("height", height)


})
</script>
