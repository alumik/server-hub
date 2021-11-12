<?php

/* @var $instance string */
/* @var $this yii\web\View */

$this->title = '综合仪表板';
?>
<iframe
        class="dashboard"
        src="http://10.10.1.210/grafana/d/9CWBz0bi/fu-wu-qi-shi-yong-qing-kuang?kiosk=&refresh=10s&var-node=<?= $instance ?>&orgId=1"></iframe>
