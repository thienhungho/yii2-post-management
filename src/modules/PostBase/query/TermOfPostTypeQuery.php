<?php

namespace thienhungho\PostManagement\modules\PostBase\query;

/**
 * This is the ActiveQuery class for [[TermOfPostType]].
 *
 * @see TermOfPostType
 */
class TermOfPostTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TermOfPostType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TermOfPostType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
