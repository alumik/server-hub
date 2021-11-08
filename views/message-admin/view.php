<?php

use app\models\Dictionary;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = '公告详情';
$this->params['breadcrumbs'][] = ['label' => '公告管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->id;
YiiAsset::register($this);
?>
<div class="message-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该条公告吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'mode',
                'value' => function ($model) {
                    return Dictionary::findOne(['name' => 'message_mode', 'key' => $model->mode])->value;
                }
            ],
            [
                'attribute' => 'show',
                'value' => ['否', '是'][$model->show],
            ],
            'text:ntext',
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
