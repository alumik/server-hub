<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $instance
 * @property string $gpu_instance
 * @property string $ip
 * @property string $ssh_user
 * @property boolean $show
 * @property boolean $show_gpu
 *
 * @property int $jobs
 */
class Server extends ActiveRecord
{
    public static function tableName()
    {
        return 'server';
    }

    public function rules()
    {
        return [
            [['instance', 'ip', 'ssh_user'], 'required'],
            [['instance', 'gpu_instance', 'ip', 'ssh_user'], 'string', 'max' => 255],
            [['instance', 'gpu_instance', 'ip'], 'unique'],
            [['show', 'show_gpu'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instance' => '实例',
            'gpu_instance' => 'GPU 实例',
            'ip' => '服务器',
            'ssh_user' => 'SSH 用户名',
            'show' => '显示',
            'show_gpu' => '显示 GPU',
        ];
    }

    public function getJobs()
    {
        $durationSec = Dictionary::find()
            ->select(['key', 'value'])
            ->where(['name' => 'job_duration_sec']);
        $now = time();
        return Job::find()
            ->joinWith(User::tableName())
            ->leftJoin(['duration_sec' => $durationSec], 'job.duration = duration_sec.key')
            ->where(['id_server' => $this->id, 'job.status' => Job::STATUS_ACTIVE])
            ->andWhere([
                '<',
                new Expression("$now - job.created_at"),
                new Expression('value')
            ])
            ->count();
    }
}
