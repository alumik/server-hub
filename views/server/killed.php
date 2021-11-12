<?php

use app\models\Server;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KillHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '进程清理历史';
$this->params['breadcrumbs'][] = ['label' => '服务器状态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("[data-toggle=\"tooltip\"]").tooltip()');
$this->registerCss('.tooltip-inner{max-width:720px;}')
?>
<div class="kill-history-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
                },
                'headerOptions' => ['class' => 'w-2'],
            ],
            [
                'attribute' => 'id_server',
                'value' => 'server.name',
                'filter' => ArrayHelper::map(Server::find()->orderBy('name')->all(), 'id', 'name'),
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'pid',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'user',
                'headerOptions' => ['class' => 'w-1'],
                'contentOptions' => ['style' => 'max-width: 120px', 'class' => 'text-truncate'],
            ],
            [
                'attribute' => 'command',
                'contentOptions' => function ($model) {
                    return [
                        'style' => 'max-width: 540px',
                        'class' => 'text-truncate',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-container' => 'body',
                        'title' => $model['command'],
                    ];
                },
            ],
        ],
    ]); ?>


</div>