<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "server".
 *
 * @property int $id
 * @property string $name
 * @property string $instance
 * @property string $gpu_instance
 * @property string $ip
 * @property string $ssh_user
 * @property boolean $console_enabled
 *
 * @property int $jobs
 */
class Server extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'server';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'instance', 'ip', 'ssh_user', 'console_enabled'], 'required'],
            [['name', 'instance', 'gpu_instance', 'ip', 'ssh_user'], 'string', 'max' => 255],
            [['name', 'instance', 'gpu_instance', 'ip'], 'unique'],
            ['console_enabled', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'instance' => '实例',
            'gpu_instance' => 'GPU 实例',
            'ip' => 'IP',
            'ssh_user' => 'SSH 用户名',
            'console_enabled' => '启用控制台',
        ];
    }

    public function getJobs()
    {
        return $this->hasMany(Job::class, ['id_server' => 'id'])->count();
    }
}
