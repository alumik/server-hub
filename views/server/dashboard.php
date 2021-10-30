<?php

/* @var $instance string */
/* @var $this yii\web\View */

$this->title = '综合仪表板';
?>

<style>
    iframe {
        width: 100%;
        height: calc(100vh - 56px);
        border: none;
        position: fixed;
        left: 0;
        top: 56px;
    }
</style>

<iframe src="http://10.10.1.210:3000/d/9CWBz0bi/fu-wu-qi-shi-yong-qing-kuang?kiosk=&refresh=10s&var-node=<?= $instance ?>&orgId=1"></iframe>
