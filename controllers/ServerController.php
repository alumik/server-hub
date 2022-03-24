<?php

namespace app\controllers;

use app\models\GpuProcessSearch;
use app\models\Job;
use app\models\JobSearch;
use app\models\KillHistorySearch;
use app\models\ProcessSearch;
use app\models\Server;
use app\models\ServerSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ServerController extends Controller
{
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

    public function actionIndex()
    {
        $searchModel = new ServerSearch();
        $params = $this->request->queryParams;
        $params['ServerSearch']['show'] = 1;
        $dataProvider = $searchModel->search($params);

        $client = new Client();
        $request = $client->createRequest()
            ->setMethod('GET')
            ->setUrl('http://10.10.1.210:9090/api/v1/query');
        $gpuUsage = $this->queryPrometheus(
            $request, 'nvidia_smi_utilization_gpu_ratio', 'metric.uuid', 'metric.instance');
        $usedGpuMem = $this->queryPrometheus(
            $request, 'nvidia_smi_memory_used_bytes', 'metric.uuid', 'metric.instance');
        $freeGpuMem = $this->queryPrometheus(
            $request, 'nvidia_smi_memory_free_bytes', 'metric.uuid', 'metric.instance');
        $memUsage = $this->queryPrometheus(
            $request, '1-node_memory_MemAvailable_bytes/node_memory_MemTotal_bytes');
        $cpuUsage = $this->queryPrometheus(
            $request, '1-avg(rate(node_cpu_seconds_total{mode="idle"}[2m]))by(instance)');
        $nodeLoad5 = $this->queryPrometheus(
            $request, 'node_load5/on(instance)count(node_cpu_seconds_total{mode="system"})by(instance)');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'gpuUsage' => $gpuUsage,
            'usedGpuMem' => $usedGpuMem,
            'freeGpuMem' => $freeGpuMem,
            'memUsage' => $memUsage,
            'cpuUsage' => $cpuUsage,
            'nodeLoad5' => $nodeLoad5,
        ]);
    }

    public function actionView($id)
    {
        Yii::$app->session->set('userView' . Yii::$app->user->id . 'returnURL', Yii::$app->request->url);

        $params = $this->request->queryParams;
        $params['JobSearch']['status'] = Job::STATUS_ACTIVE;
        $params['JobSearch']['id_server'] = $id;

        $searchModel = new JobSearch();
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

    public function actionProcess($id)
    {
        $params = $this->request->queryParams;
        $searchModel = new ProcessSearch();

        $model = $this->findModel($id);
        $dataProvider = $searchModel->search($params, $model);

        return $this->render('process', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGpuProcess($id)
    {
        $searchModel = new GpuProcessSearch();
        $model = $this->findModel($id);
        $nvidiaOutput = $searchModel->search($model);

        return $this->render('gpu-process', [
            'model' => $model,
            'nvidiaOutput' => $nvidiaOutput,
        ]);
    }

    public function actionKilled()
    {
        $searchModel = new KillHistorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('killed', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Server::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('未找到相关服务器。');
    }
}
