<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '反馈管理';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

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
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
                },
                'headerOptions' => ['class' => 'w-2'],
            ],
            [
                'attribute' => 'user.username',
                'label' => '用户',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'content',
                'contentOptions' => ['style' => 'max-width: 600px', 'class' => 'text-truncate'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('查看', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'delete' => function ($url) {
                        return Html::a('删除', $url, [
                            'class' => 'btn btn-sm btn-outline-primary',
                            'data' => [
                                'confirm' => '确定要删除该条反馈吗？',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

</div>
