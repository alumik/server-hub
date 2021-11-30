<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $date
 * @property int $id_user
 * @property int $view_count
 * @property int $updated_at
 *
 * @property User $user
 */
class SiteTraffic extends ActiveRecord
{
    public static function tableName()
    {
        return 'site_traffic';
    }

    public function rules()
    {
        return [
            [['date', 'view_count'], 'required'],
            [['date'], 'safe'],
            [['view_count'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'updated_at',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'id_user',
                    ActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
                'value' => function () {
                    return Yii::$app->user->id;
                },
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => '日期',
            'id_user' => '用户',
            'view_count' => '访问次数',
            'updated_at' => '最近访问',
        ];
    }

    public static function register()
    {
        $model = SiteTraffic::findOne(['id_user' => Yii::$app->user->id, 'date' => date('Y-m-d')]);
        if ($model) {
            $model->view_count += 1;
        } else {
            $model = new SiteTraffic();
            $model->date = date('Y-m-d');
            $model->view_count = 1;
        }
        $model->save();
    }

    public static function getTotalViewCount($date = null, $idUser = null)
    {
        $query = SiteTraffic::find()
            ->select('SUM(view_count)');
        if ($idUser) {
            $query->andWhere(['id_user' => $idUser]);
        } else {
            $query->andWhere(['<>', 'id_user', 1]);
        }
        if ($date) {
            $query->andWhere(['date' => $date]);
        }
        return $query->scalar();
    }

    public static function getViewCountHistory($limit = 10)
    {
        $query = ArrayHelper::map(SiteTraffic::find()
            ->select(['date', 'data' => 'SUM(view_count)'])
            ->where(['<>', 'id_user', 1])
            ->groupBy('date')
            ->limit($limit)
            ->asarray()
            ->all(), 'date', 'data');
        $viewCountHistory = [];
        for ($offset = 0; $offset < $limit; $offset++) {
            $date = date('Y-m-d', time() - $offset * 24 * 3600);
            $viewCountHistory[$date] = key_exists($date, $query) ? intval($query[$date]) : 0;
        }
        return $viewCountHistory;
    }

    public static function getUserCountHistory($limit = 10)
    {
        $query = ArrayHelper::map(SiteTraffic::find()
            ->select(['date', 'data' => 'COUNT(*)'])
            ->groupBy('date')
            ->limit($limit)
            ->asarray()
            ->all(), 'date', 'data');
        $userCountHistory = [];
        for ($offset = 0; $offset < $limit; $offset++) {
            $date = date('Y-m-d', time() - $offset * 24 * 3600);
            $userCountHistory[$date] = key_exists($date, $query) ? intval($query[$date]) : 0;
        }
        return $userCountHistory;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }
}
