<?php

namespace app\controllers;

use app\models\Job;
use app\models\JobSearch;
use app\models\UpdatePasswordForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new JobSearch();
        $params = $this->request->queryParams;
        $params['JobSearch']['id_user'] = $user->getId();
        $dataProvider = $searchModel->search($params);
        return $this->render('view', [
            'model' => $user,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdatePassword()
    {
        $model = new UpdatePasswordForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->updatePassword()) {
                Yii::$app->session->setFlash('success', '密码更新成功。');
                return $this->redirect('/user');
            }
        }

        return $this->render('update-password', [
            'model' => $model,
        ]);
    }
}
