<?php

use app\models\Dictionary;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Server */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->ip . ' 服务器作业记录';
$this->params['breadcrumbs'][] = ['label' => '服务器状态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = '作业';
YiiAsset::register($this);
?>
<div class="server-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
                'attribute' => 'username',
                'value' => 'user.username',
                'label' => '创建者',
                'headerOptions' => ['class' => 'w-1'],
                'contentOptions' => ['style' => 'max-width: 120px', 'class' => 'text-truncate'],
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $job) {
                        return Html::a('查看', ['/job/view', 'id' => $job->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'update' => function ($url, $job) {
                        if (Yii::$app->user->identity->admin || Yii::$app->user->id == $job->id_user) {
                            return Html::a('更新', ['/job/update', 'id' => $job->id], ['class' => 'btn btn-sm btn-outline-primary']);
                        }
                        return '';
                    },
                ]
            ],
        ],
    ]) ?>

</div>
