<?php

namespace app\controllers;

use app\models\JobSearch;
use app\models\SiteTraffic;
use app\models\UpdatePasswordForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
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
        SiteTraffic::register();

        $user = Yii::$app->user->identity;
        $searchModel = new JobSearch();

        $params = $this->request->queryParams;
        $params['JobSearch']['id_user'] = $user->id;
        $params['JobSearch']['show_outdated'] = true;
        $dataProvider = $searchModel->search($params);
        $dataProvider->sort->defaultOrder = [
            'status' => SORT_ASC,
            'created_at' => SORT_DESC,
        ];

        Yii::$app->session->set('userView' . Yii::$app->user->id . 'returnURL', Yii::$app->request->url);

        return $this->render('view', [
            'model' => $user,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate()
    {
        $model = User::findIdentity(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '姓名更新成功。');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPasswd()
    {
        $model = new UpdatePasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->updatePassword()) {
                Yii::$app->session->setFlash('success', '密码更新成功。');
                return $this->redirect(['index']);
            }
        }

        return $this->render('passwd', [
            'model' => $model,
        ]);
    }
}
