<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $description
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $id_server
 * @property int $id_user
 * @property int $duration
 * @property int pid
 * @property string server_user
 * @property string comm
 * @property boolean $use_gpu
 *
 * @property Server $server
 * @property User $user
 */
class Job extends ActiveRecord
{
    const STATUS_ACTIVE = 0;
    const STATUS_FINISHED = 1;
    const STATUS_INVALID = 2;

    public static function tableName()
    {
        return 'job';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'id_user',
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
                'value' => function ($event) {
                    $model = $event->sender;
                    if ($model->id_user === null) {
                        return Yii::$app->user->id;
                    } else {
                        return $model->id_user;
                    }
                },
            ]
        ];
    }

    public function rules()
    {
        return [
            [['description', 'id_server', 'duration', 'pid', 'server_user', 'use_gpu'], 'required'],
            [['description', 'comm', 'server_user'], 'string', 'max' => 255],
            [['status', 'id_server', 'duration', 'pid'], 'integer'],
            [['use_gpu'], 'boolean'],
            [['id_server'], 'exist', 'skipOnError' => true, 'targetClass' => Server::class, 'targetAttribute' => ['id_server' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => '内容',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'id_server' => '服务器',
            'id_user' => '创建者',
            'duration' => '运行时间',
            'pid' => '主进程 PID',
            'server_user' => '服务器用户名',
            'comm' => '进程名',
            'use_gpu' => '需要使用 GPU',
        ];
    }

    public function getServer()
    {
        return $this->hasOne(Server::class, ['id' => 'id_server']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public static function getGpuJobPid($server)
    {
        $durationSec = Dictionary::find()
            ->select(['key', 'value'])
            ->where(['name' => 'job_duration_sec']);
        $now = time();

        return ArrayHelper::getColumn(Job::find()
            ->select('pid')
            ->leftJoin(Server::tableName(), 'id_server = server.id')
            ->leftJoin(['duration_sec' => $durationSec], 'duration = duration_sec.key')
            ->where(['status' => 0, 'use_gpu' => true, 'server.ip' => $server])
            ->andWhere(['not', ['pid' => null]])
            ->andWhere([
                '<',
                new Expression("$now - job.created_at"),
                new Expression('value')
            ])
            ->all(), 'pid');
    }
}
