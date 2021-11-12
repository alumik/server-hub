<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $id_server
 * @property int $pid
 * @property string $user
 * @property string $command
 *
 * @property Server $server
 */
class KillHistory extends ActiveRecord
{
    public static function tableName()
    {
        return 'kill_history';
    }

    public function rules()
    {
        return [
            [['created_at', 'id_server', 'pid', 'user', 'command'], 'required'],
            [['created_at', 'id_server', 'pid'], 'integer'],
            [['user'], 'string', 'max' => 255],
            [['command'], 'string'],
            [['id_server'], 'exist', 'skipOnError' => true, 'targetClass' => Server::class, 'targetAttribute' => ['id_server' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => '时间',
            'id_server' => '服务器',
            'pid' => 'PID',
            'user' => '服务器用户名',
            'command' => '命令',
        ];
    }

    public function getServer()
    {
        return $this->hasOne(Server::class, ['id' => 'id_server']);
    }
}
