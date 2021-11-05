<?php

namespace app\controllers;

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

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $searchModel = new JobSearch();
        $params = $this->request->queryParams;
        $params['JobSearch']['id_user'] = $user->id;
        $dataProvider = $searchModel->search($params);
        Yii::$app->session->set('userView' . Yii::$app->user->id . 'returnURL', Yii::$app->request->url);

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

    public function actionUpdateUsername()
    {
        $model = User::findIdentity(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '姓名更新成功。');
                return $this->redirect('/user');
            }
        }

        return $this->render('update-username', [
            'model' => $model,
        ]);
    }
}
