<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use app\models\Changelog;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
    } else {
        $menuItems[] = ['label' => '服务器状态', 'url' => ['/server/index']];
        $menuItems[] = ['label' => '作业记录', 'url' => ['/job/index']];
        $menuItems[] = ['label' => '个人中心', 'url' => ['/user/index']];

        if (Yii::$app->user->identity->admin) {
            $menuItems[] = [
                'label' => '管理后台',
                'items' => [
                    ['label' => '用户管理', 'url' => ['/admin/user/index']],
                    ['label' => '公告管理', 'url' => ['/admin/message/index']],
                    ['label' => '反馈管理', 'url' => ['/admin/feedback/index']],
                    ['label' => '更新管理', 'url' => ['/admin/changelog/index']],
                    ['label' => '访问记录', 'url' => ['/admin/site-traffic/index']],
                ],
            ];
        }
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav mr-auto'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);

    if (!Yii::$app->user->isGuest) {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                '注销 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm();
    }

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; 南开大学软件学院 <?= date('Y') ?></p>
        <p class="float-right">
            <?= Html::a('反馈', '/site/feedback', ['class' => 'text-muted mr-3']) ?>
            <?= Html::a('平台版本 ' . Changelog::find()->orderBy(['created_at' => SORT_DESC])->one()->version, '/site/changelog', ['class' => 'text-muted']) ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
