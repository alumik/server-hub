<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '服务器管理';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="server-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建服务器', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'instance',
            'gpu_instance',
            'ip',
            'ssh_user',
            [
                'attribute' => 'show',
                'value' => function ($model) {
                    return ['否', '是'][$model->show];
                },
                'filter' => ['否', '是'],
            ],
            [
                'attribute' => 'show_gpu',
                'value' => function ($model) {
                    return ['否', '是'][$model->show_gpu];
                },
                'filter' => ['否', '是'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a('更新', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'delete' => function ($url) {
                        return Html::a('删除', $url, [
                            'class' => 'btn btn-sm btn-outline-primary',
                            'data' => [
                                'confirm' => '确定要删除该服务器吗？',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'contentOptions' => ['style' => 'min-width: 130px'],
            ],
        ],
    ]) ?>

</div>
