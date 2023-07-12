<?php

namespace app\controllers\api\v1;

use app\models\Dictionary;
use app\models\Job;
use app\models\Server;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class JobController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionGpu($server)
    {
        return Job::getGpuJobPid($server);
    }

    public function actionCreate()
    {
        if ($this->request->isPost) {
            $data = $this->request->post();
            $student_id = $data['student_id'];
            $password = $data['password'];

            try {
                $user = User::findOne(['student_id' => $student_id]);
                if ($user && $user->validatePassword($password)) {
                    $job = new Job();
                    $job->description = $data['description'];
                    $job->status = Job::STATUS_ACTIVE;
                    $job->id_server = Server::findOne(['ip' => $data['server_ip']])->id;
                    $job->id_user = $user->id;
                    $job->duration = Dictionary::findOne([
                        'name' => 'job_duration',
                        'value' => $data['duration'],
                        'enabled' => true,
                    ])->key;
                    $job->pid = $data['pid'];
                    $job->server_user = $data['server_user'];
                    $job->comm = $data['command'] ?? '';
                    $job->use_gpu = $data['use_gpu'];
                    if ($job->save()) {
                        return ['message' => 'success'];
                    } else {
                        return ['message' => 'job creation failed. reason: ' . json_encode($job->errors, JSON_UNESCAPED_UNICODE)];
                    }
                }
            } catch (\Exception $e) {
                return ['message' => 'job creation failed. reason: ' . $e->getMessage()];
            }
        }
        return ['message' => 'authentication failed'];
    }
}
