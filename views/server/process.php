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

?>
<div class="server-index">

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
            ],
        ],
    ]) ?>

</div>
