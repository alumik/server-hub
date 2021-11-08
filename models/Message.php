<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $mode
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 * @property bool $show
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'created_at', 'updated_at'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['mode'], 'string', 'max' => 255],
            ['show', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode' => '模式',
            'text' => '内容',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'show' => '是否显示',
        ];
    }
}
