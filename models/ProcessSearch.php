<?php

namespace app\models;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\web\UnauthorizedHttpException;

class ProcessSearch extends Model
{
    /**
     * We plan to get two columns in our grid that can be filtered.
     * Add more if required. You don't have to add all of them.
     */
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
                    'comm'
                ],
                'defaultOrder' => ['pcpu' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
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

        $output = $ssh->exec('ps --no-headers -eo pid,user:30,pcpu,rss,etimes,comm --sort -pcpu | tr -s " "');
        $data = str_getcsv($output, "\n");
        foreach ($data as &$row) {
            $exploded = str_getcsv(trim($row), ' ');
            $row = [];
            $row['pid'] = $exploded[0];
            $row['user'] = $exploded[1];
            $row['pcpu'] = $exploded[2];
            $row['rss'] = $exploded[3];
            $row['etimes'] = $exploded[4];
            $row['comm'] = $exploded[5];
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
                return array_product($conditions);
            });
        }

        return $data;
    }
}