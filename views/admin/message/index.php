<?php

use app\models\Dictionary;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公告管理';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新建公告', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'attribute' => 'mode',
                'value' => function ($model) {
                    return Dictionary::findOne(['name' => 'message_mode', 'key' => $model->mode])->value;
                },
                'filter' => ArrayHelper::map(Dictionary::find()->where(['name' => 'message_mode'])->orderBy('sort')->all(), 'key', 'value'),
            ],
            [
                'attribute' => 'show',
                'value' => function ($model) {
                    return ['否', '是'][$model->show];
                },
                'filter' => ['否', '是'],
            ],
            [
                'attribute' => 'content',
                'contentOptions' => ['style' => 'max-width: 480px', 'class' => 'text-truncate'],
            ],
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
                                'confirm' => '确定要删除该条公告吗？',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

</div>
