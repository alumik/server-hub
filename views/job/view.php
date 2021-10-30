<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Job */

$this->title = '作业记录详情';
$this->params['breadcrumbs'][] = ['label' => '作业记录', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="job-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->getId() == $model->id_user): ?>

    <p>
        <?= Html::a('更新作业记录', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => ['进行中', '已完成', '已失效'][$model->status],
            ],
            [
                'attribute' => 'duration.name',
                'label' => '预计完成时间',
            ],
            [
                'attribute' => 'server.name',
                'label' => '服务器',
            ],
            [
                'attribute' => 'user.username',
                'label' => '所有者',
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
