<?php

namespace app\controllers\admin;

use app\models\SiteTraffic;
use app\models\SiteTrafficSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class SiteTrafficController extends Controller
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

    public function beforeAction($action)
    {
        if (!Yii::$app->user->identity->admin) {
            throw new ForbiddenHttpException('你没有查看该页面的权限。');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new SiteTrafficSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $viewCountTotal = SiteTraffic::getTotalViewCount();
        $viewCountHistory = SiteTraffic::getViewCountHistory(14);
        $userCountHistory = SiteTraffic::getUserCountHistory(14);
        $viewCountToday = $viewCountHistory[date('Y-m-d')];
        $userCountToday = $userCountHistory[date('Y-m-d')];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'viewCountHistory' => $viewCountHistory,
            'userCountHistory' => $userCountHistory,
            'model' => [
                'view_count_total' => $viewCountTotal,
                'view_count_today' => $viewCountToday,
                'user_count_today' => $userCountToday,
            ],
        ]);
    }

    protected function findModel($id)
    {
        if (($model = SiteTraffic::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('未找到相关访问记录。');
    }
}
