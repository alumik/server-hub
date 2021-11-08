<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChangeLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '更新管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="change-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建更新记录', ['create'], ['class' => 'btn btn-success']) ?>
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
            'version',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('查看', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'update' => function ($url) {
                        return Html::a('更新', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'delete' => function ($url) {
                        return Html::a('删除', $url, [
                            'class' => 'btn btn-sm btn-outline-primary',
                            'data' => [
                                'confirm' => '确定要删除该条更新记录吗？',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>


</div>
