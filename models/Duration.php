<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "duration".
 *
 * @property int $id
 * @property string $name
 */
class Duration extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'duration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }
}
