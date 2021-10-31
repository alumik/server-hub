<?php

use yii\bootstrap4\Progress;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $freeGpuMem array */
/* @var $memUsage array */
/* @var $cpuUsage array */
/* @var $nodeLoad5 array */

$this->title = '服务器状态';
$this->params['breadcrumbs'][] = $this->title;

function formatBytes($bytes)
{
    if ($bytes > 0) {
        $i = floor(log($bytes) / log(1024));
        $sizes = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
        return sprintf('%.02F', round($bytes / pow(1024, $i), 1)) * 1 . ' ' . @$sizes[$i];
    }
    return 0;
}

function threshold($value, $warning, $danger)
{
    if ($value < $warning) {
        return 'bg-success';
    }
    if ($value < $danger) {
        return 'bg-warning';
    }
    return 'bg-danger';
}

function percentage($value)
{
    return number_format($value, 2) . '%';
}

$this->registerJs('
    $(function () {
        $("[data-toggle=\"tooltip\"]").tooltip()
    })', $this::POS_END, 'tooltips');

$this->registerJs(' 
    setInterval(function(){  
         $.pjax.reload({container:"#server"});
    }, 5000);', $this::POS_HEAD);
?>
<div class="server-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['id' => 'server']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'name',
                'headerOptions' => ['style' => 'width:140px'],
            ],
            [
                'label' => 'CPU 使用',
                'value' => function ($model) use ($cpuUsage) {
                    if (key_exists($model->instance, $cpuUsage)) {
                        $percent = $cpuUsage[$model->instance] * 100;
                        $class = threshold($percent, 70, 90);
                        return Progress::widget([
                            'percent' => $percent,
                            'barOptions' => ['class' => $class],
                            'options' => ['class' => 'bg-secondary'],
                            'label' => percentage($percent),
                        ]);
                    }
                    return 'N/A';
                },
                'format' => 'html',
            ],
            [
                'label' => '平均负载',
                'value' => function ($model) use ($nodeLoad5) {
                    if (key_exists($model->instance, $nodeLoad5)) {
                        $percent = $nodeLoad5[$model->instance] * 100;
                        $class = threshold($percent, 100, 500);
                        return Progress::widget([
                            'percent' => $percent,
                            'barOptions' => ['class' => $class],
                            'options' => ['class' => 'bg-secondary'],
                            'label' => percentage($percent),
                        ]);
                    }
                    return 'N/A';
                },
                'format' => 'html',
                'headerOptions' => [
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top', // top, bottom, left, right
                    'data-container' => 'body', // to prevent breaking table on hover
                    'title' => '平均负载定义为5分钟内平均进程数/CPU逻辑核心数。平均负载大于100%表明服务器负载过大，大于500%则不应在服务器上执行更多任务。',
                ]
            ],
            [
                'label' => '内存使用',
                'value' => function ($model) use ($memUsage) {
                    if (key_exists($model->instance, $memUsage)) {
                        $percent = $memUsage[$model->instance] * 100;
                        $class = threshold($percent, 70, 90);
                        return Progress::widget([
                            'percent' => $percent,
                            'barOptions' => ['class' => $class],
                            'options' => ['class' => 'bg-secondary'],
                            'label' => percentage($percent),
                        ]);
                    }
                    return 'N/A';
                },
                'format' => 'html',
            ],
            [
                'label' => '可用显存（点击查看详情）',
                'value' => function ($model) use ($freeGpuMem) {
                    $instance = substr_replace($model->instance, '9835', -4);
                    if (!array_key_exists($instance, $freeGpuMem)) {
                        return 'N/A';
                    }
                    $gpuDashboard = '';
                    foreach ($freeGpuMem[$instance] as $uuid => $gpu) {
                        if ($gpu > 24 * 1024 * 1024 * 1024) {
                            $class = 'text-success';
                        } elseif ($gpu < 2 * 1024 * 1024 * 1024) {
                            $class = 'text-danger';
                        } elseif ($gpu < 4 * 1024 * 1024 * 1024) {
                            $class = 'text-warning';
                        } else {
                            $class = 'text-dark';
                        }
                        $gpuDashboard .= '<span class="' . $class . '">';
                        $gpuDashboard .= Html::a(
                            formatBytes($gpu),
                            ['/server/gpu-dashboard', 'instance' => $instance, 'uuid' => $uuid],
                            ['class' => $class]
                        );
                        $gpuDashboard .= '</span>';
                        $gpuDashboard .= ' / ';
                    }
                    return substr($gpuDashboard, 0, -3);
                },
                'format' => 'raw',
            ],
            [
                'label' => '当前作业',
                'value' => 'jobs',
                'headerOptions' => ['style' => 'width:100px'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {dashboard}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('查看当前作业', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'dashboard' => function ($url, $model) {
                        return Html::a(
                            '仪表板',
                            ['/server/dashboard', 'instance' => $model->instance],
                            ['class' => 'btn btn-sm btn-outline-primary']
                        );
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>
