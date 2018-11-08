<?php

namespace thienhungho\PostManagement\modules\PostBase\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "{{%post_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \thienhungho\PostManagement\modules\PostBase\Post[] $posts
 */
class PostType extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'posts'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_type}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(\thienhungho\PostManagement\modules\PostBase\Post::className(), ['post_type' => 'name']);
    }
    
    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @return \thienhungho\PostManagement\modules\PostBase\query\PostTypeQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \thienhungho\PostManagement\modules\PostBase\query\PostTypeQuery(get_called_class());
    }
}
