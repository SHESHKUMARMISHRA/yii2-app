<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\ArrayDataProvider;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new \app\models\ClaimSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // public function actionIndex()
    // {
    //    // return $this->render('index');
    //    $data = [
    //         [
    //             'id' => 1,
    //             'file_number' => 'FN-1001',
    //             'manager_name' => 'Amit Sharma',
    //             'service_provider' => 'ABC Services',
    //             'claim_number' => 'CLM-9001',
    //             'assignment_id' => 'ASG-5001',
    //             'company_name' => 'XYZ Insurance',
    //             'invoice_date' => '2025-01-10',
    //             'expenses' => 5000,
    //             'sales_tax' => 900,
    //             'payment_amount' => 4500,
    //             'balance_amount' => 1400,
    //             'payment_date' => '2025-01-20',
    //             'loss_amount' => 2000,
    //             'details' => 'Detailed description for FN-1001'
    //         ],
    //         [
    //             'id' => 2,
    //             'file_number' => 'FN-1002',
    //             'manager_name' => 'Rohit Verma',
    //             'service_provider' => 'Delta Corp',
    //             'claim_number' => 'CLM-9002',
    //             'assignment_id' => 'ASG-5002',
    //             'company_name' => 'LMN Insurance',
    //             'invoice_date' => '2025-01-12',
    //             'expenses' => 7000,
    //             'sales_tax' => 1260,
    //             'payment_amount' => 6000,
    //             'balance_amount' => 2260,
    //             'payment_date' => '2025-01-25',
    //             'loss_amount' => 3500,
    //             'details' => 'Detailed description for FN-1002'
    //         ],
    //     ];

    //     $dataProvider = new ArrayDataProvider([
    //         'allModels' => $data,
    //         'pagination' => [
    //             'pageSize' => 10,
    //         ],
    //         'sort' => [
    //             'attributes' => [
    //                 'file_number',
    //                 'manager_name',
    //                 'invoice_date',
    //                 'payment_amount',
    //             ],
    //         ],
    //     ]);

    //     return $this->render('index', [
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
