<?php

use app\models\Dictionary;
use app\models\Server;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '作业记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-plus-square"></i> 新建作业记录', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('<i class="fa fa-history"></i> 进程清理历史', ['/server/killed'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-comment-alt"></i>', ['/site/feedback'], ['class' => 'btn btn-primary', 'title' => '反馈']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y/m/d', $model->created_at);
                },
            ],
            [
                'attribute' => 'username',
                'value' => 'user.username',
                'label' => '创建者',
                'headerOptions' => ['class' => 'w-1'],
                'contentOptions' => ['style' => 'max-width: 120px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'id_server',
                'value' => 'server.ip',
                'filter' => ArrayHelper::map(Server::find()->orderBy('ip')->all(), 'id', 'ip'),
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
                'value' => function ($model) {
                    if ($model->use_gpu) {
                        return Html::img('@web/img/nvidia.svg', ['alt' => 'USE GPU', 'class' => 'inline-logo mr-1']) . $model->description;
                    } else {
                        return $model->description;
                    }
                },
                'format' => 'html',
                'contentOptions' => ['style' => 'max-width: 240px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'duration',
                'value' => function ($model) {
                    return Dictionary::findOne(['name' => 'job_duration', 'key' => $model->duration])->value;
                },
                'filter' => ArrayHelper::map(Dictionary::find()->where(['name' => 'job_duration'])->orderBy('sort')->all(), 'key', 'value'),
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('查看', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'update' => function ($url, $model) {
                        if (Yii::$app->user->identity->admin || Yii::$app->user->id == $model->id_user) {
                            return Html::a('更新', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]) ?>

</div>
