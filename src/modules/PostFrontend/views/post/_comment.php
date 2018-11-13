<?php

?>

<div class="review" style="padding-bottom: 4px">
    <div class="user-img" style="background-image: url(/<?= empty($model->author0->avatar) ? \thienhungho\UserManagement\models\User::DEFAULT_AVATAR : $model->author0->avatar?>)"></div>
    <div class="desc">
        <h4>
            <span class="text-left"><?= $model->author_name ?></span>
            <span class="text-right"><?= $model->created_at ?></span>
        </h4>
        <p><?= $model->content ?></p>
        <p class="star">
            <span class="text-left"><a href="#comment-form" class="reply" onclick="document.getElementById('Comment[parent]').value = <?= $model->id ?>"><i class="icon-reply"></i></a></span>
        </p>
    </div>
</div>

<?php

if (!empty($model->child)) {
    foreach ($model->child as $child) { ?>
        <div class="review" style="padding-bottom: 4px; width: 90%; float: right;">
            <div class="user-img" style="/<?= empty($child->author0->avatar) ? \thienhungho\UserManagement\models\User::DEFAULT_AVATAR : get_other_img_size_path('thumbnail', $child->author0->avatar) ?>"></div>
            <div class="desc">
                <h4>
                    <span class="text-left"><?= $child->author_name ?></span>
                    <span class="text-right"><?= $child->created_at ?></span>
                </h4>
                <p><?= $child->content ?></p>
                <p class="star">
                    <span class="text-left"><a href="#comment-form" class="reply" onclick="document.getElementById('Comment[parent]').value = <?= $model->id ?>"><i class="icon-reply"></i></a></span>
                </p>
            </div>
        </div>
    <?php }
}
?>
