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
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->updated_at);
                },
                'filter' => '',
            ],
            [
                'attribute' => 'username',
                'value' => 'user.username',
                'label' => '所有者',
                'headerOptions' => ['style' => 'width: 120px'],
            ],
            [
                'attribute' => 'id_server',
                'value' => 'server.name',
                'filter' => ArrayHelper::map(Server::find()->orderBy('name')->all(), 'id', 'name'),
            ],
            [
                'attribute' => 'description',
                'contentOptions' => ['class' => 'truncate'],
            ],
            [
                'attribute' => 'duration',
                'value' => function ($model) {
                    return Dictionary::findOne(['name' => 'job_duration', 'key' => $model->duration])->value;
                },
                'filter' => ArrayHelper::map(Dictionary::find()->where(['name' => 'job_duration'])->orderBy('sort')->all(), 'key', 'value'),
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
