<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

if (empty($model->author)) {
    $model->author = Yii::$app->user->id;
}
if (empty($model->language)) {
    $model->language = get_primary_language();
}
if (empty($model->id)) {
    $model->id = 0;
}
?>

<div class="row post-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'post_type', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <div class="col-lg-9 col-xs-12">
        <?= $form->field($model, 'title', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-edit"></span>']],
        ])->textInput([
            'maxlength'   => true,
            'placeholder' => t('app', 'Title'),
        ]) ?>

        <?=
        $form->field($model, 'content')->widget(froala\froalaeditor\FroalaEditorWidget::className(), [
            'clientOptions' => [
                'toolbarInline'         => false,
                'language'              => substr(Yii::$app->language, 0, 2),
                'height'                => '500px',
                'fontFamilySelection'   => true,
                'fontSizeSelection'     => true,
                'videoAllowedProviders' => [
                    'youtube',
                    'vimeo',
                    'facebook',
                ],
                'videoInsertButtons'    => [
                    'videoBack',
                    '|',
                    'videoByURL',
                ],
                'imageUploadParam'      => 'file',
                'imageUploadURL'        => \yii\helpers\Url::to(['/upload']),
            ],
        ]);
        ?>

    </div>

    <div class="col-lg-3 col-xs-12">

        <?= $form->field($model, 'author', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-user"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\UserManagement\models\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
            'options'       => ['placeholder' => t('app', 'Choose User')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?= $form->field($model, 'post_parent', [
            'addon' => ['prepend' => ['content' => '<span class="fa fa-copy"></span>']],
        ])->widget(\kartik\widgets\Select2::classname(), [
            'data'          => \yii\helpers\ArrayHelper::map(\thienhungho\PostManagement\modules\PostBase\Post::find()->where(['post_parent' => 0])->andWhere(['post_type' => $model->post_type])->orderBy('id')->asArray()->all(), 'id', 'title'),
            'options'       => ['placeholder' => t('app', 'Post Parent')],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]); ?>

        <?php
        if (is_enable_multiple_language()) {
            echo language_select_input($form, $model, 'language');
        }
        ?>

        <?php
        $termTypes = get_all_term_type_of_post_type($model->post_type);
        foreach ($termTypes as $termType) { ?>
            <div class="form-group">
                <label class="category-label"><?= t('app', ucfirst($termType['name'])) ?></label>
                <?=
                \kartik\widgets\Select2::widget([
                    'addon'         => ['prepend' => ['content' => '<span class="fa fa-paperclip"></span>']],
                    'name'          => $termType['name'] . '[]',
                    'value'         => get_all_term_name_of_obj($model->post_type, $model->primaryKey, $termType['name']),
                    'data'          => \yii\helpers\ArrayHelper::map(\common\modules\terms\Term::find()->select('name')->orderBy('id')->asArray()->where(['term_type' => $termType['name']])->all(), 'name', 'name'),
                    'options'       => [
                        'multiple'    => true,
                        'placeholder' => t('app', 'Choose') . ' ' . t('app', ucfirst($termType['name'])),
                    ],
                    'pluginOptions' => [
                        'allowClear'         => true,
                        'tags'               => true,
                        'tokenSeparators'    => [','],
                        'maximumInputLength' => 225,
                    ],
                ])
                ?>
            </div>
        <?php }
        ?>


    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <?= Html::submitButton(t('app', 'Create'), [
                'class' => 'btn btn-success',
                'value' => '1',
                'name'  => '_asnew',
            ]) ?>
            <?= Html::a(t('app', 'Cancel'), request()->referrer, ['class' => 'btn btn-danger']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
