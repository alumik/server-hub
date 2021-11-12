<?php

/* @var $instance string */
/* @var $uuid string */
/* @var $this yii\web\View */

$this->title = 'GPU 仪表板';
?>
<iframe
        class="dashboard"
        src="http://10.10.1.210/grafana/d/vlvPlrgnk/gpu-shi-yong-qing-kuang?refresh=10s&var-node=<?= $instance ?>&var-gpu=<?= $uuid ?>&orgId=1"></iframe>
