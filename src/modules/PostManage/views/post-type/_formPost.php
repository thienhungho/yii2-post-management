<div class="form-group" id="add-post">
<?php
use thienhungho\Widgets\models\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Post',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden'=>true]],
        'title' => ['type' => TabularForm::INPUT_TEXT],
        'slug' => ['type' => TabularForm::INPUT_TEXT],
        'content' => ['type' => TabularForm::INPUT_TEXTAREA],
        'author' => [
            'label' => 'User',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\BaseApp\ums\modules\UserBase\User::find()->orderBy('username')->asArray()->all(), 'id', 'username'),
                'options' => ['placeholder' => t('app', 'Choose User')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'feature_img' => ['type' => TabularForm::INPUT_TEXT],
        'status' => ['type' => TabularForm::INPUT_TEXT],
        'comment_status' => ['type' => TabularForm::INPUT_TEXT],
        'post_parent' => ['type' => TabularForm::INPUT_TEXT],
        'language' => ['type' => TabularForm::INPUT_TEXT],
        'assign_with' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return
                    Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                    Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  t('app', 'Delete'), 'onClick' => 'delRowPost(' . $key . '); return false;', 'id' => 'post-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . t('app', 'Add Post'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowPost()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

