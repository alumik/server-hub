<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dictionary".
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $value
 * @property int $sort
 */
class Dictionary extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dictionary';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'key', 'value'], 'required'],
            [['sort'], 'integer'],
            [['name', 'key', 'value'], 'string', 'max' => 255],
            [['name', 'key'], 'unique', 'targetAttribute' => ['name', 'key']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'key' => 'Key',
            'value' => 'Value',
            'sort' => 'Sort',
        ];
    }
}
