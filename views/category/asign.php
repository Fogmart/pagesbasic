<?php
    /* @var $pages common\models\Page */
    /* @var $groups common\models\Group */
?>
<style>
    td {
        padding: 8px;
    }
</style>
<table cellpadding="3" cellspacing="5" border="1">
    <tr>
        <td></td>
        <?php foreach ($cats as $cat){?>
            <td><?=$cat->name?></td>
        <?php } ?>
    </tr>
    <?php foreach ($groups as $group){?>
        <tr gr="<?=$group->id?>" >
            <td><?=$group->name?></td>
            <?php

            foreach ($cats as $cat){?>
                <td>
                    <input type="checkbox" cat="<?=$cat->id?>"
                        <?php if (in_array($group->id, $cat->groupIdsArray)) {
                            echo "checked";
                        }?>
                            onclick="toggleGroup(this)"
                    >
                </td>
            <?php } ?>
        </tr>
    <?php } ?>

</table>

<script>
    function toggleGroup(cb) {
        var tr = $(cb).parents("tr")
        $.post("/category/assigngroup",{"groupid":$(tr).attr("gr"),"catid": $(cb).attr("cat"),"set": $(cb).prop("checked")})
    }
</script>

