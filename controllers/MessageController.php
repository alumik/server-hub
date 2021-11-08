<?php

namespace app\controllers;

use app\models\ChangeLog;
use app\models\Message;
use yii\filters\AccessControl;
use yii\web\Controller;

class MessageController extends Controller
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
        $messages = Message::find()->where(['show' => true])->orderBy(['updated_at' => SORT_DESC])->all();
        $changeLogs = ChangeLog::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'messages' => $messages,
            'changeLogs' => $changeLogs,
        ]);
    }
}
