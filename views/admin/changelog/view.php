<?php

use yii\bootstrap4\Html;
use yii\helpers\Markdown;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Changelog */

$this->title = $model->version;
$this->params['breadcrumbs'][] = '管理后台';
$this->params['breadcrumbs'][] = ['label' => '更新管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
YiiAsset::register($this);
?>
<div class="changelog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该条更新记录吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th class="w-1">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
                },
            ],
            'version',
            [
                'attribute' => 'content',
                'value' => Markdown::process($model->content),
                'format' => 'html',
            ]
        ],
    ]) ?>

</div>
