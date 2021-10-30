<?php

use yii\bootstrap4\Html;

$this->title = Yii::$app->name;
?>

<div class="site-index">

    <div class="jumbotron text-center">
        <?= Html::img('@web/nankai-logo.svg', ['alt' => '南开大学', 'class' => 'jumbotron-logo']); ?>
        <h1>南开大学软件学院服务器作业查询平台</h1>
        <hr/>
        <p id="hitokoto"></p>
    </div>
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">服务器状态查询</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">浏览服务器状态列表。<br/>查询服务器CPU、内存、GPU等使用情况。</p>
                        <a class="btn btn-outline-primary" href="/server">前往服务器状态 &raquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">服务器作业记录</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">提交服务器作业记录。<br/>查询所有已提交的服务器作业记录。</p>
                        <a class="btn btn-outline-primary" href="/job">前往作业记录 &raquo;</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">个人中心</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">修改个人信息。<br/>查询自己提交的服务器作业记录。</p>
                        <a class="btn btn-outline-primary" href="/user">前往个人中心 &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var xhr = new XMLHttpRequest();
    xhr.open('get', 'https://v1.hitokoto.cn?c=d&c=h&c=i&c=k');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            var data = JSON.parse(xhr.responseText);
            var hitokoto = document.getElementById('hitokoto');
            if (data.hitokoto !== undefined) {
                hitokoto.innerText = data.hitokoto;
            } else {
                hitokoto.innerText = '不经一番寒彻骨，怎得梅花扑鼻香。'
            }
        }
    }
    xhr.send();
</script>
