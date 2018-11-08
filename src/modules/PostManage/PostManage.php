<?php

namespace thienhungho\PostManagement\modules\PostManage;

/**
 * PostManage module definition class
 */
class PostManage extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post'     => t('app', 'post'),
            'page'     => t('app', 'page'),
            'portfolio'     => t('app', 'portfolio'),
            'category' => t('app', 'category'),
            'tag'      => t('app', 'tag'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'thienhungho\PostManagement\modules\PostManage\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
