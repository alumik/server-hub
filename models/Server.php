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
            [['name', 'instance'], 'required'],
            [['name', 'instance', 'gpu_instance'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['instance', 'gpu_instance'], 'unique'],
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
        ];
    }

    public function getJobs()
    {
        return $this->hasMany(Job::class, ['id_server' => 'id'])->count();
    }
}
