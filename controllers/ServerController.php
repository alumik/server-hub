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

    private function queryPrometheus($request, $query, $from = 'metric.instance', $group = null)
    {
        $response = $request->setData(['query' => $query])->send();
        return ArrayHelper::map($response->data['data']['result'], $from, 'value.1', $group);
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
        $freeGpuMem = $this->queryPrometheus(
            $request, 'nvidia_smi_memory_total_bytes-nvidia_smi_memory_used_bytes', 'metric.uuid', 'metric.instance');
        $memUsage = $this->queryPrometheus(
            $request, '1-node_memory_MemAvailable_bytes/node_memory_MemTotal_bytes');
        $cpuUsage = $this->queryPrometheus(
            $request, '1-avg(rate(node_cpu_seconds_total{mode="idle"}[2m]))by(instance)');
        $nodeLoad5 = $this->queryPrometheus(
            $request, 'node_load5/on(instance)count(node_cpu_seconds_total{mode="system"})by(instance)');

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

        throw new NotFoundHttpException('未找到相关服务器。');
    }
}
