<?php

namespace app\models;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;
use yii\web\UnauthorizedHttpException;

class GpuProcessSearch
{
    public function search($server)
    {
        $ssh = new SSH2($server->ip);

        $key = PublicKeyLoader::load(file_get_contents('/var/www/default/id_rsa'));
        if (!$ssh->login($server->ssh_user, $key)) {
            throw new UnauthorizedHttpException('服务器鉴权失败。');
        }

        return $ssh->exec('nvidia-smi');
    }
}
