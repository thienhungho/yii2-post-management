<?php
$limitComment = Yii::$app->request->get('number-comment', 1);
?>


<?= $model->title ?>

<?= $model->content ?>

<?php
$numberComment = \thienhungho\CommentManagement\models\Comment::find()
    ->where(['obj_type' => $model->post_type])
    ->andWhere(['obj_id' => $model->getPrimaryKey()])
    ->andWhere(['type' => $model->post_type . '-comment'])
    ->andWhere(['status' => STATUS_PUBLIC])
    ->count();
?>
<?= $numberComment ?><?php
$dataProvider = new \yii\data\ActiveDataProvider([
    'query'      => \thienhungho\CommentManagement\models\Comment::find()
        ->where(['obj_type' => $model->post_type])
        ->andWhere(['obj_id' => $model->getPrimaryKey()])
        ->andWhere(['type' => $model->post_type . '-comment'])
        ->andWhere(['status' => STATUS_PUBLIC])
        ->andWhere(['parent' => null])
        ->with('author0')
        ->with('child'),
    'pagination' => [
        'pageSize' => $limitComment,
    ],
]);
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => '/post/_comment',
    'summary'      => '',
]);
?>
<?= $this->render('/post/_comment_form', ['model' => $model]) ?>