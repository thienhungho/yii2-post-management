<?php
$this->title = Yii::t('app', slug_to_text($type));
?>
<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView'     => '_post',
    'summary'      => '',
]); ?>
