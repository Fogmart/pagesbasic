<?php
    /* @var $pages app\models\Page */
    /* @var $groups app\models\Group */
    /* @var $catsphp app\models\CategoriesPhp */
    /* @var $cats app\models\Category */
?>
<style>
    td {
        padding: 8px;
    }
</style>
<p>читать/редактировать/комментировать</p>
<table cellpadding="3" cellspacing="5" border="1">
    <tr>
        <td></td>
        <?php foreach ($groups  as $group){?>
            <td><?=$group->name?></td>
        <?php } ?>
    </tr>

    <?php
    $colspan = 1;
    foreach ($cats as $cat){
        $colspan++;
        ?>
        <tr gr="<?=$cat->id?>" >
            <td><?=$cat->name?></td>
            <?php

            foreach ($groups as $group){?>
                <td align="center">
                    <input type="checkbox" cat="<?=$group->id?>"
                        <?php if (in_array($cat->id, $group->catsReadIds)) {
                            echo "checked";
                        }?>
                            onclick="toggleGroup(this, 'read')"
                    >
                    <input type="checkbox" cat="<?=$group->id?>"
                        <?php if (in_array($cat->id, $group->catsEditIds)) {
                            echo "checked";
                        }?>
                            onclick="toggleGroup(this, 'edit')"
                    >
                    <input type="checkbox" cat="<?=$group->id?>"
                        <?php if (in_array($cat->id, $group->catsCommentIds)) {
                            echo "checked";
                        }?>
                            onclick="toggleGroup(this, 'comment')"
                    >
                </td>

            <?php } ?>
        </tr>
    <?php } ?>

    <tr>
        <td colspan="<?=$colspan?>"> PHP </td>
    </tr>
    <?php foreach ($catsphp as $cat){?>
        <tr gr="<?=$cat->id?>" >
            <td><?=$cat->name?></td>
            <?php

            foreach ($groups as $group){?>
                <td align="center">
                    <input type="checkbox" cat="<?=$group->id?>"
                        <?php if (in_array($cat->id, $group->catphpReadIds)) {
                            echo "checked";
                        }?>
                           onclick="toggleGroupPhp(this)"
                    >

                </td>

            <?php } ?>
        </tr>
    <?php } ?>

</table>

<script>
    function toggleGroup(cb, act) {
        var tr = $(cb).parents("tr")
        $.post("/category/assigngroup",{
            "catid":$(tr).attr("gr"),
            "groupid": $(cb).attr("cat"),
            "act": act,
            "set": $(cb).prop("checked")})
    }
    function toggleGroupPhp(cb, act) {
        var tr = $(cb).parents("tr")
        $.post("/catphp/assigngroup",{
            "catid":$(tr).attr("gr"),
            "groupid": $(cb).attr("cat"),
            "set": $(cb).prop("checked")})
    }
</script>

