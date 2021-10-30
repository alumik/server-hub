<?php

/* @var $instance string */
/* @var $uuid string */
/* @var $this yii\web\View */

$this->title = 'GPU 仪表板';
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

<iframe src="http://10.10.1.210:3000/d/vlvPlrgnk/gpu-shi-yong-qing-kuang?refresh=10s&var-node=<?= $instance ?>&var-gpu=<?= $uuid ?>&orgId=1"></iframe>
