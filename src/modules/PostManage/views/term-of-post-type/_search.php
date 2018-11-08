<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model thienhungho\PostManagement\modules\PostManage\search\TermOfPostTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-term-of-post-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'post_type')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\thienhungho\PostManagement\modules\PostBase\PostType::find()->orderBy('name')->asArray()->all(), 'name', 'name'),
        'options' => ['placeholder' => t('app', 'Choose Post type')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'input_type')->textInput(['maxlength' => true, 'placeholder' => 'Input Type']) ?>

    <div class="form-group">
        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
