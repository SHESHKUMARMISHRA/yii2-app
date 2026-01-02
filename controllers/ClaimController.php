<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ClaimSearch;

class ClaimController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ClaimSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
