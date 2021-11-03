<?php

use app\models\Duration;
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
                'attribute' => 'updated_at',
                'value' => function ($jobModel) {
                    return date('Y年m月d日 H:i:s', $jobModel->updated_at);
                },
                'filter' => '',
            ],
            [
                'attribute' => 'username',
                'value' => 'user.username',
                'label' => '所有者',
                'headerOptions' => ['style' => 'width:110px'],
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
                        if (Yii::$app->user->identity->getId() == $jobModel->id_user) {
                            return Html::a('更新', ['/job/update', 'id' => $jobModel->id], ['class' => 'btn btn-sm btn-outline-primary']);
                        }
                        return '';
                    },
                ]
            ],
        ],
    ]) ?>

</div>
