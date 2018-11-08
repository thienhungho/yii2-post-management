<?php
// @var $model is call to Post model
$view_url = \yii\helpers\Url::to([
    '/post/post/view',
    'type' => $model->post_type,
    'slug' => $model->slug,
]);
$created_at = date('d', strtotime($model->created_at));
$author_username = $model->author0->username;
$description = substr(strip_tags($model->content), 0, 120);

echo '<a href="' . $view_url . '">' . $model->title . '</a>';
