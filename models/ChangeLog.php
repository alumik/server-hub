<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "change_log".
 *
 * @property int $id
 * @property string $text
 * @property int $created_at
 * @property string $version
 */
class ChangeLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'change_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'created_at', 'version'], 'required'],
            [['text'], 'string'],
            [['created_at'], 'integer'],
            [['version'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => '内容',
            'created_at' => '创建时间',
            'version' => '版本号',
        ];
    }
}
