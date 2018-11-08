<?php

namespace thienhungho\PostManagement\modules\PostBase\query;

/**
 * This is the ActiveQuery class for [[\common\modules\users\PostType]].
 *
 * @see \common\modules\users\PostType
 */
class PostTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \common\modules\users\PostType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\modules\users\PostType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
