<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $value
 * @property int $sort
 * @property boolean $enabled
 */
class Dictionary extends ActiveRecord
{
    public static function tableName()
    {
        return 'dictionary';
    }

    public function rules()
    {
        return [
            [['name', 'key', 'value', 'sort'], 'required'],
            [['sort'], 'integer'],
            [['name', 'key', 'value'], 'string', 'max' => 255],
            [['name', 'key'], 'unique', 'targetAttribute' => ['name', 'key']],
            ['enabled', 'boolean'],
        ];
    }
}
