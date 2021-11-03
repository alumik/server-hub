<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Server */
/* @var $searchModel app\models\ProcessSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = $model->name . '当前进程';
$this->params['breadcrumbs'][] = ['label' => '服务器状态', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
$this->params['breadcrumbs'][] = '进程';

function formatBytes($bytes)
{
    if ($bytes > 0) {
        $i = floor(log($bytes) / log(1024));
        $sizes = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        return sprintf('%.02F', round($bytes / pow(1024, $i), 1)) * 1 . ' ' . @$sizes[$i];
    }
    return 0;
}

function formatPercentage($value)
{
    return number_format($value, 2) . '%';
}

function formatTime($value)
{
    $s = str_pad($value % 60, 2, '0', STR_PAD_LEFT);
    $m = str_pad(floor(($value % 3600) / 60), 2, '0', STR_PAD_LEFT);
    $h = str_pad(floor(($value % 86400) / 3600), 2, '0', STR_PAD_LEFT);
    $d = floor($value / 86400);
    return "${d}天 $h:$m:$s";
}

$this->registerJs('
    $(function () {
        $("[data-toggle=\"tooltip\"]").tooltip()
    })', $this::POS_END, 'tooltips');
?>
<style>
    .tooltip-inner {
        max-width: 720px;
    }

     .server-process tr {
         height: 20px;
         line-height: 1rem;
     }

    .server-process td {
        padding: 0.5rem;
    }
</style>

<div class="server-process">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => '首页',
            'lastPageLabel' => '末页',
        ],
        'columns' => [
            [
                'attribute' => 'pid',
                'label' => 'PID',
            ],
            [
                'attribute' => 'user',
                'label' => '用户名',
            ],
            [
                'attribute' => 'pcpu',
                'label' => '平均 CPU 使用',
                'value' => function ($model) {
                    return formatPercentage($model['pcpu']);
                },
                'headerOptions' => [
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data-container' => 'body',
                    'title' => '进程使用的 CPU 时间除以进程运行的时间，并非实时 CPU 使用情况。',
                ],
            ],
            [
                'attribute' => 'rss',
                'label' => '内存使用',
                'value' => function ($model) {
                    return formatBytes($model['rss'] * 1024);
                },
            ],
            [
                'attribute' => 'etimes',
                'label' => '运行时间',
                'value' => function ($model) {
                    return formatTime($model['etimes']);
                },
            ],
            [
                'attribute' => 'comm',
                'label' => '命令',
                'contentOptions' => function ($model) {
                    return [
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-container' => 'body',
                        'title' => $model['cmd'],
                    ];
                },
            ],
        ],
    ]) ?>

</div>
