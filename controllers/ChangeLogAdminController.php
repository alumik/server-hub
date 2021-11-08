<?php

namespace app\controllers;

use app\models\ChangeLog;
use app\models\ChangeLogSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * ChangeLogAdminController implements the CRUD actions for ChangeLog model.
 */
class ChangeLogAdminController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ChangeLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->identity->admin) {
            throw new ForbiddenHttpException('你没有查看该页面的权限。');
        }
        $searchModel = new ChangeLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChangeLog model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->identity->admin) {
            throw new ForbiddenHttpException('你没有查看该页面的权限。');
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ChangeLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->identity->admin) {
            throw new ForbiddenHttpException('你没有查看该页面的权限。');
        }
        $model = new ChangeLog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->created_at = time();
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ChangeLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->identity->admin) {
            throw new ForbiddenHttpException('你没有查看该页面的权限。');
        }
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ChangeLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->identity->admin) {
            throw new ForbiddenHttpException('你没有查看该页面的权限。');
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ChangeLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ChangeLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChangeLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('未找到相关更新记录。');
    }
}
