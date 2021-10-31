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
        return 'N/A';
    }
    $percent = $values[$instance] * 100;
    $class = getBackgroundColorClass($percent, $thresholds[0], $thresholds[1]);
    return Progress::widget([
        'percent' => $percent,
        'barOptions' => ['class' => $class],
        'options' => ['class' => 'bg-secondary'],
        'label' => formatPercentage($percent),
    ]);
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
                    return gauge($model->instance, $cpuUsage, [70, 90]);
                },
                'format' => 'html',
            ],
            [
                'label' => '平均负载',
                'value' => function ($model) use ($nodeLoad5) {
                    return gauge($model->instance, $nodeLoad5, [100, 500]);
                },
                'headerOptions' => [
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data-container' => 'body',
                    'title' => '平均负载定义为5分钟内平均进程数/CPU逻辑核心数。平均负载大于100%表明服务器负载过大，大于500%则不应在服务器上执行更多任务。',
                ],
                'format' => 'html',
            ],
            [
                'label' => '内存使用',
                'value' => function ($model) use ($memUsage) {
                    return gauge($model->instance, $memUsage, [70, 90]);
                },
                'format' => 'html',
            ],
            [
                'label' => '可用显存（点击查看详情）',
                'value' => function ($model) use ($freeGpuMem) {
                    $instance = $model->gpu_instance;
                    if (!$instance || !key_exists($instance, $freeGpuMem)) {
                        return 'N/A';
                    }
                    $gpuDashboard = '';
                    foreach ($freeGpuMem[$instance] as $uuid => $_freeGpuMem) {
                        if ($_freeGpuMem < 2 * 1024 * 1024 * 1024) {
                            $class = 'text-danger';
                        } elseif ($_freeGpuMem < 4 * 1024 * 1024 * 1024) {
                            $class = 'text-warning';
                        } elseif ($_freeGpuMem < 24 * 1024 * 1024 * 1024) {
                            $class = 'text-dark';
                        } else {
                            $class = 'text-success';
                        }
                        $gpuDashboard .= Html::a(
                            formatBytes($_freeGpuMem),
                            ['/server/gpu-dashboard', 'instance' => $instance, 'uuid' => $uuid],
                            ['class' => $class]
                        );
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
                    'view' => function ($url) {
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
    ]) ?>
    <?php Pjax::end() ?>

</div>
