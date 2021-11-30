<?php

namespace app\controllers;

use app\models\Job;
use app\models\JobSearch;
use app\models\SiteTraffic;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class JobController extends Controller
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

    public function actionIndex()
    {
        Yii::$app->session->setFlash('danger', '请务必准确填写和及时更新 PID。平台每隔30分钟会定期清理一次未登记的 GPU 进程。');
        Yii::$app->session->set('userView' . Yii::$app->user->id . 'returnURL', Yii::$app->request->url);
        SiteTraffic::register();

        $searchModel = new JobSearch();

        $params = $this->request->queryParams;
        $params['JobSearch']['status'] = Job::STATUS_ACTIVE;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        Yii::$app->session->set('userView' . Yii::$app->user->id . 'returnURL', Yii::$app->request->url);

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Job();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->status = Job::STATUS_ACTIVE;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '作业记录创建成功。');
                return $this->redirect(Yii::$app->session->get('userView' . Yii::$app->user->id . 'returnURL') ?: '/job');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!Yii::$app->user->identity->admin && Yii::$app->user->id != $model->id_user) {
            throw new ForbiddenHttpException('你没有修改该条记录的权限。');
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '作业记录更新成功。');
                return $this->redirect(Yii::$app->session->get('userView' . Yii::$app->user->id . 'returnURL') ?: '/job');
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('未找到相关作业记录。');
    }
}
