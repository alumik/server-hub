<?php

use app\models\Duration;
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
        <?= Html::a('修改密码', ['update-password'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('修改姓名', ['update-username'], ['class' => 'btn btn-primary']) ?>
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
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->updated_at);
                },
                'filter' => '',
            ],
            [
                'attribute' => 'status',
                'value' => function ($jobModel) {
                    return ['进行中', '已完成', '已失效'][$jobModel->status];
                },
                'filter' => ['进行中', '已完成', '已失效'],
            ],
            [
                'attribute' => 'id_server',
                'value' => 'server.name',
                'filter' => ArrayHelper::map(Server::find()->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['class' => 'truncate'],
            ],
            [
                'attribute' => 'id_duration',
                'value' => 'duration.name',
                'filter' => ArrayHelper::map(Duration::find()->orderBy('id')->all(), 'id', 'name'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $jobModel) {
                        return Html::a('查看', ['/job/view', 'id' => $jobModel->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'update' => function ($url, $jobModel) {
                        return Html::a('更新', ['/job/update', 'id' => $jobModel->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                ]
            ],
        ],
    ]) ?>

</div>
