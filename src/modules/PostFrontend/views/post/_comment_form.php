<?php

$hiddenNotUseInput = false;
if (!Yii::$app->user->isGuest) {
    $hiddenNotUseInput = true;
}

?>

<div class="row animate-box">
    <div class="col-md-12">
        <h2 class="colorlib-heading-2"><?= Yii::t('app', 'Comment') ?></h2>
        <form action="" method="post">
            <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
                value="<?=Yii::$app->request->csrfToken?>"/>
            <input type="hidden" id="Comment[obj_type]" class="form-control" name="Comment[obj_type]" value="<?= $model->post_type ?>"/>
            <input type="hidden" id="Comment[obj_id]" class="form-control" name="Comment[obj_id]" value="<?= $model->id ?>"/>
            <input type="hidden" id="Comment[type]" class="form-control" name="Comment[type]" value="<?= $model->post_type ?>-comment"/>
            <input type="hidden" id="Comment[parent]" class="form-control" name="Comment[parent]" value=""/>
            <?php
            if (!Yii::$app->user->isGuest) { ?>
                <input type="hidden" id="Comment[author]" name="Comment[author]" value="<?= Yii::$app->user->id ?>" />
                <input type="hidden" id="Comment[author_name]" name="Comment[author_name]" value="<?= Yii::$app->user->identity->username ?>"/>
                <input type="hidden" id="Comment[author_email]" name="Comment[author_email]" value="<?= Yii::$app->user->identity->email ?>" />
                <input type="hidden" id="Comment[author_url]" name="Comment[author_url]" value="/" />
            <?php } else { ?>
                <div class="row form-group">
                    <div class="col-md-6">
                        <!-- <label for="fname">First Name</label> -->
                        <input type="text" id="Comment[author_name]" class="form-control" name="Comment[author_name]" placeholder="<?= Yii::t('app', 'Name') ?>" />
                    </div>
                    <div class="col-md-6">
                        <!-- <label for="lname">Last Name</label> -->
                        <input type="email" id="Comment[author_email]" class="form-control" name="Comment[author_email]" placeholder="<?= Yii::t('app', 'Email') ?>" />
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-12">
                        <!-- <label for="email">Email</label> -->
                        <input type="text" id="Comment[author_url]" name="Comment[author_url]" class="form-control" placeholder="<?= Yii::t('app', 'Url') ?>" />
                    </div>
                </div>
            <?php }
            ?>

            <div class="row form-group">
                <div class="col-md-12">
                    <!-- <label for="message">Message</label> -->
                    <textarea name="Comment[content]" id="Comment[content]" cols="30" rows="10" class="form-control" placeholder="<?= Yii::t('app', 'Content') ?>"></textarea>
                </div>
            </div>
            <div class="form-group">
                <input type="submit" value="<?= Yii::t('app', 'Post Comment') ?>" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>