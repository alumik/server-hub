<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $mode
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property boolean $show
 */
class Message extends ActiveRecord
{
    public static function tableName()
    {
        return 'message';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['mode', 'content'], 'required'],
            [['mode'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['show'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode' => '类型',
            'content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'show' => '公开',
        ];
    }
}
