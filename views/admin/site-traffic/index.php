<?php

use app\assets\MomentJsAsset;
use dosamigos\chartjs\ChartJs;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model array */
/* @var $viewCountHistory array */
/* @var $userCountHistory array */
/* @var $searchModel app\models\SiteTrafficSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '访问记录';
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = $this->title;

$fontFamilyEn = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"';

MomentJsAsset::register($this);
?>
<div class="site-traffic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th class="w-2">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'view_count_total',
                'label' => '总访问量',
            ],
            [
                'attribute' => 'view_count_today',
                'label' => '今日访问量',
            ],
            [
                'attribute' => 'user_count_today',
                'label' => '今日访问用户数',
            ],
        ],
    ]) ?>

    <div class="chart-container position-relative mb-3">
        <?= ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => '180px',
            ],
            'data' => [
                'labels' => array_keys($viewCountHistory),
                'datasets' => [
                    [
                        'data' => array_values($viewCountHistory),
                        'fill' => true,
                        'borderColor' => '#830257',
                        'backgroundColor' => 'rgba(131, 2, 87, 0.2)',
                        'pointBackgroundColor' => '#830257',
                    ],
                ],
            ],
            'clientOptions' => [
                'maintainAspectRatio' => false,
                'legend' => [
                    'display' => false,
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'type' => 'time',
                            'time' => [
                                'unit' => 'day',
                                'displayFormats' => [
                                    'day' => 'MM/DD',
                                ],
                                'tooltipFormat' => 'YYYY/MM/DD ddd',
                            ],
                            'ticks' => [
                                'fontColor' => '#000',
                                'fontSize' => 16,
                                'fontFamily' => $fontFamilyEn,
                                'padding' => 10,
                            ],
                            'gridLines' => [
                                'drawTicks' => false,
                            ],
                        ],
                    ],
                    'yAxes' => [
                        [
                            'ticks' => [
                                'fontColor' => '#000',
                                'fontSize' => 16,
                                'fontFamily' => $fontFamilyEn,
                                'beginAtZero' => true,
                                'padding' => 10,
                            ],
                            'scaleLabel' => [
                                'display' => true,
                                'labelString' => '访问量',
                                'fontColor' => '#000',
                                'fontSize' => 16,
                                'fontFamily' => $fontFamilyEn,
                            ],
                            'gridLines' => [
                                'drawTicks' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ]) ?>
    </div>

    <div class="chart-container position-relative mb-3">
        <?= ChartJs::widget([
            'type' => 'line',
            'options' => [
                'height' => '180px',
            ],
            'data' => [
                'labels' => array_keys($userCountHistory),
                'datasets' => [
                    [
                        'data' => array_values($userCountHistory),
                        'fill' => true,
                        'borderColor' => '#343a40',
                        'backgroundColor' => 'rgba(82, 88, 93, 0.2)',
                        'pointBackgroundColor' => '#343a40',
                    ],
                ],
            ],
            'clientOptions' => [
                'maintainAspectRatio' => false,
                'legend' => [
                    'display' => false,
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'type' => 'time',
                            'time' => [
                                'unit' => 'day',
                                'displayFormats' => [
                                    'day' => 'MM/DD',
                                ],
                                'tooltipFormat' => 'YYYY/MM/DD ddd',
                            ],
                            'ticks' => [
                                'fontColor' => '#000',
                                'fontSize' => 16,
                                'fontFamily' => $fontFamilyEn,
                                'padding' => 10,
                            ],
                            'gridLines' => [
                                'drawTicks' => false,
                            ],
                        ],
                    ],
                    'yAxes' => [
                        [
                            'ticks' => [
                                'fontColor' => '#000',
                                'fontSize' => 16,
                                'fontFamily' => $fontFamilyEn,
                                'beginAtZero' => true,
                                'padding' => 10,
                            ],
                            'scaleLabel' => [
                                'display' => true,
                                'labelString' => '访问用户数',
                                'fontColor' => '#000',
                                'fontSize' => 16,
                                'fontFamily' => $fontFamilyEn,
                            ],
                            'gridLines' => [
                                'drawTicks' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ]) ?>
    </div>

    <h2>详细访问记录</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    $date = DateTime::createFromFormat('Y-m-d', $model->date);
                    return $date->format('Y/m/d');
                },
                'headerOptions' => ['class' => 'w-1'],
            ],
            [
                'attribute' => 'username',
                'value' => 'user.username',
                'label' => '用户',
                'headerOptions' => ['class' => 'w-1'],
                'contentOptions' => ['style' => 'max-width: 120px', 'class' => 'text-truncate'],
            ],
            'view_count',
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->updated_at);
                },
            ],
        ],
    ]) ?>

</div>
