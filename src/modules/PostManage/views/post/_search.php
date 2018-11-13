<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostManage\search\PostSearch */
/* @var $form yii\widgets\ActiveForm */

$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

?>

<div class="form-post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title', [
        'addon' => ['prepend' => ['content' => '<span class="fa fa-edit"></span>']],
    ])->textInput([
        'maxlength'   => true,
        'placeholder' => t('app', 'Title'),
    ]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author', [
        'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
    ])->widget(\kartik\widgets\Select2::classname(), [
        'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\UserManagement\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options'       => ['placeholder' => t('app', 'Choose User')],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?php
    if (is_enable_multiple_language()) {
        echo language_select_input($form, $model, 'language');
        echo $form->field($model, 'assign_with', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-paperclip"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\PostManagement\modules\PostBase\Post::find()->orderBy('id')->where(['assign_with' => 0])->andWhere(['post_type' => $post_type])->asArray()->all(), 'id', 'title'),
            'options'       => ['placeholder' => t('app', 'Assign With')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
