<?php

namespace app\controllers\api\v1;

use app\models\Job;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class JobController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionGpu($server)
    {
        return Job::getGpuJobPid($server);
    }
}
