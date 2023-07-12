<?php

use app\models\Dictionary;
use yii\bootstrap4\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = '作业记录详情';
$this->params['breadcrumbs'][] = ['label' => '作业记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
YiiAsset::register($this);
?>
<div class="job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->admin || Yii::$app->user->id == $model->id_user): ?>
        <p>
            <?= Html::a('<i class="fa fa-edit"></i> 更新作业记录', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif ?>

    <h2>作业内容</h2>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th class="w-2">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'server.ip',
            'server_user',
            'pid',
            [
                'attribute' => 'comm',
                'value' => $model->comm ?: Html::tag('span', '(未设置)', ['class' => 'not-set']),
                'format' => 'html',
            ],
            [
                'attribute' => 'use_gpu',
                'value' => function ($model) {
                    return ['否', '是'][$model->use_gpu];
                }
            ],
            'description:ntext',
        ],
    ]) ?>

    <h2>作业状态</h2>

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th class="w-2">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'status',
                'value' => ['进行中', '已完成', '已关闭'][$model->status],
            ],
            [
                'attribute' => 'duration',
                'value' => function ($model) {
                    return Dictionary::findOne(['name' => 'job_duration', 'key' => $model->duration])->value;
                }
            ],
            [
                'attribute' => 'user.username',
                'label' => '创建者',
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->created_at);
                },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return date('Y年m月d日 H:i:s', $model->updated_at);
                },
            ],
        ],
    ]) ?>

</div>
