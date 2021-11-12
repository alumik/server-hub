<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $content
 * @property int $created_at
 * @property string $version
 * @property boolean $update_timestamp
 */
class Changelog extends ActiveRecord
{
    public $update_timestamp = false;

    public static function tableName()
    {
        return 'changelog';
    }

    public function rules()
    {
        return [
            [['content', 'created_at', 'version', 'update_timestamp'], 'required'],
            [['content'], 'string'],
            [['created_at'], 'integer'],
            [['version'], 'string', 'max' => 255],
            [['update_timestamp'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'created_at' => '发布时间',
            'version' => '版本号',
            'update_timestamp' => '更新发布时间',
        ];
    }
}
