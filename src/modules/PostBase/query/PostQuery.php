<?php

namespace thienhungho\PostManagement\modules\PostBase\query;

use yii\db\ActiveQuery;

/**
 * Class PostQuery
 * @package thienhungho\PostManagement\modules\PostBase\query
 */
class PostQuery extends ActiveQuery
{
    /**
     * @param $status
     *
     * @return $this
     */
    public function status($status)
    {
        if ($status != PARAMS_VALUE_ALL) {
            $this->andWhere(['status' => $status]);
        }

        return $this;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function type($type)
    {
        if ($type != PARAMS_VALUE_ALL) {
            $this->andWhere(['post_type' => $type]);
        }

        return $this;
    }

    /**
     * @param $data_type
     *
     * @return $this
     */
    public function dataType($data_type)
    {
        if ($data_type === DATA_TYPE_ARRAY) {
            $this->asArray();
        }

        return $this;
    }

    /**
     * @inheritdoc
     * @return \thienhungho\PostManagement\modules\PostBase\query\Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \thienhungho\PostManagement\modules\PostBase\query\Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
