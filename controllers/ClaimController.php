<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ClaimSearch;
use yii\web\Response;
use yii\helpers\ArrayHelper;

class ClaimController extends Controller
{
    public function actionIndex()
    {
         $session = \Yii::$app->session;
            $allColumns = \Yii::$app->params['claimGridColumns'];

            if (!$session->has('claimGridConfig')) {
                // Default configuration
                $session->set(
                    'claimGridConfig',
                    ArrayHelper::map($allColumns, fn($c) => $c['default'], fn($c) => $c['default'])
                );
            }
        $searchModel = new ClaimSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columnsConfig' => $session->get('claimGridConfig'),
            'allColumns' => $allColumns,
        ]);
    }

    public function actionSaveGridConfig()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $columns = \Yii::$app->request->post('columns', []);
        \Yii::$app->session->set('claimGridConfig', $columns);

        return ['success' => true];
    }
}
