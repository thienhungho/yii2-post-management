<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;

$items = [
    [
        'label'   => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode(t('app', 'Post')),
        'content' => $this->render('_detail', [
            'model' => $model,
        ]),
    ],
];
echo TabsX::widget([
    'items'         => $items,
    'position'      => TabsX::POS_ABOVE,
    'encodeLabels'  => false,
    'class'         => 'tes',
    'pluginOptions' => [
        'bordered'    => true,
        'sideways'    => true,
        'enableCache' => false,
    ],
]);
?>
