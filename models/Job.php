<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "job".
 *
 * @property int $id
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $id_server
 * @property int $id_user
 * @property int $id_duration
 *
 * @property Server $server
 * @property User $user
 * @property Duration $duration
 */
class Job extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_FINISHED = 1;
    const STATUS_INVALID = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'created_at', 'updated_at', 'id_server', 'id_user', 'id_duration'], 'required'],
            [['description'], 'string'],
            [['status', 'created_at', 'updated_at', 'id_server', 'id_user', 'id_duration'], 'integer'],
            [['id_server'], 'exist', 'skipOnError' => true, 'targetClass' => Server::class, 'targetAttribute' => ['id_server' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
            [['id_duration'], 'exist', 'skipOnError' => true, 'targetClass' => Duration::class, 'targetAttribute' => ['id_duration' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => '内容',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'id_server' => '服务器',
            'id_user' => '所有者',
            'id_duration' => '预计完成时间',
        ];
    }

    /**
     * Gets query for [[Server]].
     *
     * @return ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(Server::class, ['id' => 'id_server']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    /**
     * Gets query for [[Duration]].
     *
     * @return ActiveQuery
     */
    public function getDuration()
    {
        return $this->hasOne(Duration::class, ['id' => 'id_duration']);
    }
}
