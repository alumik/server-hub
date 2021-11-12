<?php

namespace app\controllers\api\v1;

use app\models\KillHistory;
use app\models\Server;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ServerController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionKilled()
    {
        if ($this->request->isPost) {
            $data = $this->request->post();
            $model = new KillHistory();
            $model->created_at = time();
            $model->id_server = Server::findOne(['name' => $data['server'] . ' 服务器'])->id;
            $model->pid = $data['pid'];
            $model->user = $data['user'];
            $model->command = $data['command'];
            if ($model->save()) {
                return ['status' => 'success'];
            }
        }
        return ['status' => 'failed'];
    }
}
