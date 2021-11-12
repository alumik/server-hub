<?php

namespace app\models;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\web\UnauthorizedHttpException;

class ProcessSearch extends Model
{
    public $pid;
    public $user;
    public $comm;


    public function rules()
    {
        return [
            [['user', 'comm'], 'string'],
            ['pid', 'integer'],
        ];
    }

    /**
     * In this example we keep this special property to know if columns should be
     * filtered or not. See search() method below.
     */
    private $_filtered = false;

    /**
     * This method returns ArrayDataProvider.
     * Filtered and sorted if required.
     */
    public function search($params, $server)
    {
        /**
         * $params is the array of GET parameters passed in the actionExample().
         * These are being loaded and validated.
         * If validation is successful _filtered property is set to true to prepare
         * data source. If not - data source is displayed without any filtering.
         */
        if ($this->load($params) && $this->validate()) {
            $this->_filtered = true;
        }

        return new ArrayDataProvider([
            'allModels' => $this->getData($server),
            'sort' => [
                'attributes' => [
                    'pid',
                    'user',
                    'pcpu' => ['default' => SORT_DESC],
                    'rss' => ['default' => SORT_DESC],
                    'etimes' => ['default' => SORT_DESC],
                    'comm',
                ],
                'defaultOrder' => ['pcpu' => SORT_DESC],
            ],
            'pagination' => false,
        ]);
    }

    /**
     * Here we are preparing the data source and applying the filters
     * if _filtered property is set to true.
     */
    protected function getData($server)
    {

        $ssh = new SSH2($server->ip);

        $key = PublicKeyLoader::load(file_get_contents('/var/www/default/id_rsa'));
        if (!$ssh->login($server->ssh_user, $key)) {
            throw new UnauthorizedHttpException('服务器鉴权失败。');
        }

        $output = $ssh->exec('ps -eo pid:10,user:30,pcpu:7,rss:10,etimes:10,comm,cmd --sort -pcpu');
        $lines = explode("\n", $output);

        $pos_user = strpos($lines[0], 'USER');
        $pos_pcpu = strpos($lines[0], '%CPU');
        $pos_rss = strpos($lines[0], 'RSS');
        $pos_comm = strpos($lines[0], 'COMMAND');
        $pos_cmd = strpos($lines[0], 'CMD');

        $data = [];
        for ($i = 1; $i < count($lines) - 1; $i++) {
            $line = $lines[$i];
            $row = [];
            $row['pid'] = intval(trim(substr($line, 0, 10)));
            $row['user'] = trim(substr($line, $pos_user, 30));
            $row['pcpu'] = floatval(trim(substr($line, $pos_user + 31, 7)));
            $row['rss'] = intval(trim(substr($line, $pos_pcpu + 5, 10)));
            $row['etimes'] = intval(trim(substr($line, $pos_rss + 4, 10)));
            $row['comm'] = trim(substr($line, $pos_comm, $pos_cmd - $pos_comm - 1));
            $row['cmd'] = trim(substr($line, $pos_cmd));
            $data[] = $row;
        }

        if ($this->_filtered) {
            $data = array_filter($data, function ($value) {
                $conditions = [true];
                if (!empty($this->pid)) {
                    $conditions[] = $value['pid'] == $this->pid;
                }
                if (!empty($this->user)) {
                    $conditions[] = strpos($value['user'], $this->user) !== false;
                }
                if (!empty($this->comm)) {
                    $conditions[] = strpos($value['comm'], $this->comm) !== false;
                }
                if (!empty($this->cmd)) {
                    $conditions[] = strpos($value['cmd'], $this->cmd) !== false;
                }
                return array_product($conditions);
            });
        }

        return $data;
    }
}
