<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['class' => 'w-0'],
            ],
            [
                'attribute' => 'student_id',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'username',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
                },
            ],
            [
                'attribute' => 'admin',
                'value' => function ($model) {
                    return ['否', '是'][$model->admin];
                },
                'filter' => ['否', '是'],
            ],
            'view_count',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{job} {update} {passwd}',
                'buttons' => [
                    'job' => function ($url, $model) {
                        return Html::a('作业记录', ['/job', 'JobSearch[username]' => $model->username], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'update' => function ($url) {
                        return Html::a('修改信息', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'passwd' => function ($url) {
                        return Html::a('修改密码', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                ],
            ],
        ],
    ]) ?>

</div>
