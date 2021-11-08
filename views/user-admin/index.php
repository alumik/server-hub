<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'student_id',
            'username',
            [
                'attribute' => 'admin',
                'value' => function ($model) {
                    return ['否', '是'][$model->admin];
                },
                'filter' => ['否', '是'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a('更新', $url, ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                ],
            ],
        ],
    ]) ?>

</div>
