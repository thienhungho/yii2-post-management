<?php

namespace thienhungho\PostManagement\modules\PostBase\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base model class for table "{{%term_of_post_type}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $post_type
 * @property string $input_type
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \thienhungho\PostManagement\modules\PostBase\PostType $postType
 */
class TermOfPostType extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames()
    {
        return [
            'postType'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'post_type'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['name', 'post_type', 'input_type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%term_of_post_type}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'post_type' => Yii::t('app', 'Post Type'),
            'input_type' => Yii::t('app', 'Input Type'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostType()
    {
        return $this->hasOne(\thienhungho\PostManagement\modules\PostBase\PostType::className(), ['name' => 'post_type']);
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
     * @return \thienhungho\PostManagement\modules\PostBase\query\TermOfPostTypeQuery
     */
    public static function find()
    {
        return new \thienhungho\PostManagement\modules\PostBase\query\TermOfPostTypeQuery(get_called_class());
    }
}
