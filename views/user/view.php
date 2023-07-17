<?php

use app\models\Dictionary;
use app\models\Job;
use app\models\Server;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '个人中心';
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($model->username) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-user-edit"></i> 修改姓名', ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-key"></i> 修改密码', ['passwd'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'student_id',
            'username',
            [
                'attribute' => 'created_at',
                'value' => date('Y年m月d日 H:i:s', $model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('Y年m月d日 H:i:s', $model->updated_at),
            ],
        ],
    ]) ?>

    <h2>我提交的作业记录</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => '&laquo;',
            'lastPageLabel' => '&raquo;',
            'prevPageLabel' => '&lsaquo;',
            'nextPageLabel' => '&rsaquo;',
        ],
        'columns' => [
            [
                'attribute' => 'created_at',
                'value' => function ($job) {
                    return date('Y/m/d', $job->created_at);
                },
            ],
            [
                'attribute' => 'id_server',
                'value' => 'server.ip',
                'filter' => ArrayHelper::map(Server::find()->all(), 'id', 'ip'),
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'server_user',
                'label' => '服务器用户名',
                'headerOptions' => ['class' => 'w-1'],
                'contentOptions' => ['style' => 'max-width: 120px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'pid',
                'label' => 'PID',
                'headerOptions' => ['class' => 'w-0'],
            ],
            [
                'attribute' => 'description',
                'value' => function ($job) {
                    if ($job->use_gpu) {
                        return Html::img('@web/img/nvidia.svg', ['alt' => 'USE GPU', 'class' => 'inline-logo mr-1']) . $job->description;
                    } else {
                        return $job->description;
                    }
                },
                'format' => 'html',
                'contentOptions' => ['style' => 'max-width: 240px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'duration',
                'value' => function ($job) {
                    return Dictionary::findOne(['name' => 'job_duration', 'key' => $job->duration])->value;
                },
                'filter' => ArrayHelper::map(Dictionary::find()->where(['name' => 'job_duration'])->orderBy('sort')->all(), 'key', 'value'),
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'status',
                'value' => function ($job) {
                    $limit = intval(Dictionary::findOne(['name' => 'job_duration_sec', 'key' => $job->duration])->value);
                    if (time() - $job->created_at > $limit && $job->status == 0) {
                        return '<span class="not-set">已过期</span>';
                    }
                    return ['进行中', '已完成', '已关闭'][$job->status];
                },
                'filter' => ['进行中', '已完成', '已关闭'],
                'headerOptions' => ['class' => 'w-1'],
                'format' => 'html',
                'contentOptions' => function ($job) {
                    if ($job->status == Job::STATUS_ACTIVE) {
                        return ['class' => 'text-success'];
                    }
                    return [];
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $job) {
                        return Html::a('查看', ['/job/view', 'id' => $job->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'update' => function ($url, $job) {
                        return Html::a('更新', ['/job/update', 'id' => $job->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                ]
            ],
        ],
    ]) ?>

</div>
