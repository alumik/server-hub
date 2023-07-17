<?php

use yii\bootstrap4\Progress;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $gpuUsage array */
/* @var $usedGpuMem array */
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

function getBackgroundColorClass($value, $warning, $danger)
{
    if ($value < $warning) return 'bg-success';
    if ($value < $danger) return 'bg-warning';
    return 'bg-danger';
}

function formatPercentage($value)
{
    return number_format($value, 2) . '%';
}

function gauge($instance, $values, $thresholds)
{
    if (!key_exists($instance, $values)) {
        return Html::tag('div', '未知', ['class' => 'text-muted']);
    }
    $percent = $values[$instance] * 100;
    $class = getBackgroundColorClass($percent, $thresholds[0], $thresholds[1]);
    return Progress::widget([
        'percent' => $percent,
        'barOptions' => ['class' => $class],
        'options' => ['class' => 'bg-secondary'],
        'label' => '&nbsp;' . formatPercentage($percent),
    ]);
}

$this->registerJs('setInterval(function(){$.pjax.reload({container:"#server"})},10000)');
?>
<div class="server-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        每隔十秒自动刷新
    </p>

    <?php Pjax::begin(['id' => 'server']) ?>
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
                'attribute' => 'ip',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'label' => 'CPU 使用',
                'value' => function ($model) use ($cpuUsage) {
                    return gauge($model->instance, $cpuUsage, [70, 90]);
                },
                'format' => 'html',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'label' => '平均负载',
                'value' => function ($model) use ($nodeLoad5) {
                    return gauge($model->instance, $nodeLoad5, [100, 500]);
                },
                'format' => 'html',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'label' => '内存使用',
                'value' => function ($model) use ($memUsage) {
                    return gauge($model->instance, $memUsage, [70, 90]);
                },
                'format' => 'html',
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'label' => 'GPU 使用',
                'value' => function ($model) use ($gpuUsage, $usedGpuMem, $freeGpuMem) {
                    $instance = $model->gpu_instance;
                    if (!$instance || !key_exists($instance, $freeGpuMem)) {
                        return Html::tag('div', '无 GPU', ['class' => 'text-muted']);
                    }
                    if (!$model->show_gpu) {
                        return Html::tag('div', '信息不可用', ['class' => 'text-muted']);
                    }
                    $gpuUsageStr = Html::tag('div', '使用率<br/>已用显存<br/>可用显存', ['class' => 'gpu-info d-inline-block text-muted']);
                    foreach ($gpuUsage[$instance] as $uuid => $_gpuUsage) {
                        $gpuUsageStr .= Html::beginTag('div', ['class' => 'gpu-info d-inline-block']);
                        if ($_gpuUsage < 0.7) {
                            $class = 'text-success';
                        } elseif ($_gpuUsage < 0.9) {
                            $class = 'text-warning';
                        } else {
                            $class = 'text-danger';
                        }
                        $gpuUsageStr .= Html::a(
                            formatPercentage($_gpuUsage * 100),
                            ['/server/gpu-dashboard', 'instance' => $instance, 'uuid' => $uuid],
                            ['class' => $class]
                        );
                        $gpuUsageStr .= '<br/>' . formatBytes($usedGpuMem[$instance][$uuid]);
                        $gpuUsageStr .= '<br/>' . formatBytes($freeGpuMem[$instance][$uuid]);
                        $gpuUsageStr .= Html::endTag('div');
                    }
                    return $gpuUsageStr;
                },
                'format' => 'raw',
                'contentOptions' => ['class' => 'text-nowrap'],
            ],
            [
                'label' => '作业数',
                'value' => 'jobs',
                'headerOptions' => ['class' => 'w-0'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {process}',
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<i class="fa fa-clipboard"></i> 作业记录', $url, ['class' => 'btn btn-sm btn-primary', 'data-pjax' => 0]);
                    },
//                    'dashboard' => function ($url, $model) {
//                        return Html::a(
//                            '<i class="fa fa-tachometer-alt"></i> 仪表板',
//                            ['/server/dashboard', 'instance' => $model->instance],
//                            ['class' => 'btn btn-sm btn-primary', 'data-pjax' => 0, 'target' => '_blank']
//                        );
//                    },
                    'process' => function ($url, $model) use ($freeGpuMem) {
                        $gpuProcess = '';
                        $instance = $model->gpu_instance;
                        if ($instance && key_exists($instance, $freeGpuMem) && $model->show_gpu) {
                            $gpuProcess = Html::a('GPU 进程', ['gpu-process', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-primary', 'data-pjax' => 0, 'target' => '_blank']);
                        }
                        return '<br/>' . Html::beginTag('div', ['class' => 'btn-group mt-1', 'role' => 'group']) .
                            Html::a('CPU 进程', $url, ['class' => 'btn btn-sm btn-outline-primary', 'data-pjax' => 0, 'target' => '_blank']) .
                            $gpuProcess .
                            Html::endTag('div');
                    },
                ],
            ],
        ],
    ]) ?>
    <?php Pjax::end() ?>

    <p>
        注：<strong>平均负载</strong>定义为 5 分钟内平均进程数与 CPU 逻辑核心数之比。平均负载大于 100% 表明服务器负载过大，大于
        500% 则不应在服务器上执行更多任务。
    </p>

</div>
