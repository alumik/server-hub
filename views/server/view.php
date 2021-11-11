<?php

use app\models\Dictionary;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Server */
/* @var $searchModel app\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->name . '作业记录';
$this->params['breadcrumbs'][] = ['label' => '服务器状态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = '作业';
YiiAsset::register($this);
?>
<div class="server-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建作业记录', ['/job/create', 'idServer' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

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
                'attribute' => 'username',
                'value' => 'user.username',
                'label' => '创建者',
                'headerOptions' => ['style' => 'width: 100px'],
                'contentOptions' => ['style' => 'max-width: 100px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'server_user',
                'label' => '服务器用户名',
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
