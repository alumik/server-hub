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
        <?= Html::a('新建作业记录', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
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
                'attribute' => 'id_server',
                'value' => 'server.name',
                'filter' => ArrayHelper::map(Server::find()->orderBy('name')->all(), 'id', 'name'),
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
                'value' => function ($model) {
                    return Dictionary::findOne(['name' => 'job_duration', 'key' => $model->duration])->value;
                },
                'filter' => ArrayHelper::map(Dictionary::find()->where(['name' => 'job_duration'])->orderBy('sort')->all(), 'key', 'value'),
                'headerOptions' => ['style' => 'width: 1px'],
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
