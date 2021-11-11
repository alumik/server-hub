<?php

use app\models\Dictionary;
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
        <?= Html::a('修改姓名', ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('修改密码', ['passwd'], ['class' => 'btn btn-primary']) ?>
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
        'columns' => [
            [
                'attribute' => 'created_at',
                'value' => function ($job) {
                    return date('Y年m月d日 H:i:s', $job->created_at);
                },
            ],
            [
                'attribute' => 'id_server',
                'value' => 'server.name',
                'filter' => ArrayHelper::map(Server::find()->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'server_user',
                'label' => '服务器用户名',
                'headerOptions' => ['style' => 'width: 140px'],
                'contentOptions' => ['style' => 'max-width: 140px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['style' => 'max-width: 250px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'duration',
                'value' => function ($job) {
                    return Dictionary::findOne(['name' => 'job_duration', 'key' => $job->duration])->value;
                },
                'filter' => ArrayHelper::map(Dictionary::find()->where(['name' => 'job_duration'])->orderBy('sort')->all(), 'key', 'value'),
                'headerOptions' => ['style' => 'width: 1px'],
            ],
            [
                'attribute' => 'status',
                'value' => function ($job) {
                    return ['进行中', '已完成', '已失效'][$job->status];
                },
                'filter' => ['进行中', '已完成', '已失效'],
                'headerOptions' => ['style' => 'width: 100px'],
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
