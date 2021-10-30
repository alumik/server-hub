<?php

namespace app\controllers;

use app\models\Job;
use app\models\JobSearch;
use app\models\Server;
use app\models\ServerSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ServerController implements the CRUD actions for Server model.
 */
class ServerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Server models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $client = new Client();
        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://10.10.1.210:9090/api/v1/query');

        $response = $request
            ->setData(['query' => 'nvidia_smi_memory_total_bytes-nvidia_smi_memory_used_bytes'])
            ->send();
        $freeGpuMem = $response->data['data']['result'];
        $freeGpuMem = ArrayHelper::map($freeGpuMem, 'metric.uuid', 'value.1', 'metric.instance');

        $response = $request
            ->setData(['query' => '1-node_memory_MemAvailable_bytes/node_memory_MemTotal_bytes'])
            ->send();
        $memUsage = $response->data['data']['result'];
        $memUsage = ArrayHelper::map($memUsage, 'metric.instance', 'value.1');

        $response = $request
            ->setData(['query' => '1-avg(rate(node_cpu_seconds_total{mode="idle"}[2m]))by(instance)'])
            ->send();
        $cpuUsage = $response->data['data']['result'];
        $cpuUsage = ArrayHelper::map($cpuUsage, 'metric.instance', 'value.1');

        $response = $request
            ->setData(['query' => 'count(node_cpu_seconds_total{mode="system"})by(instance)'])
            ->send();
        $cpuCores = $response->data['data']['result'];
        $cpuCores = ArrayHelper::map($cpuCores, 'metric.instance', 'value.1');

        $response = $request
            ->setData(['query' => 'node_load5'])
            ->send();
        $nodeLoad5 = $response->data['data']['result'];
        $nodeLoad5 = ArrayHelper::map($nodeLoad5, 'metric.instance', 'value.1');

        foreach ($cpuCores as $instance => $cpuCore) {
            $nodeLoad5[$instance] =  $nodeLoad5[$instance] / $cpuCore;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'freeGpuMem' => $freeGpuMem,
            'memUsage' => $memUsage,
            'cpuUsage' => $cpuUsage,
            'nodeLoad5' => $nodeLoad5,
        ]);
    }

    /**
     * Displays a single Server model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new JobSearch();
        $params = $this->request->queryParams;
        $params['JobSearch']['status'] = Job::STATUS_ACTIVE;
        $params['JobSearch']['id_server'] = $id;
        $dataProvider = $searchModel->search($params);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDashboard($instance)
    {
        return $this->render('dashboard', [
            'instance' => $instance,
        ]);
    }

    public function actionGpuDashboard($instance, $uuid)
    {
        return $this->render('gpu-dashboard', [
            'instance' => $instance,
            'uuid' => $uuid,
        ]);
    }

    /**
     * Finds the Server model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Server the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Server::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
