<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = 'Claims Grid';

?>

<h2><?= Html::encode($this->title) ?></h2>

<?php Pjax::begin(['id' => 'claims-grid']); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'file_number',
        'manager_name',
        'service_provider',
        'claim_number',
        'assignment_id',
        'company_name',

        [
            'attribute' => 'invoice_date',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'invoice_date',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
            ]),
        ],

        'expenses',
        'sales_tax',
        'payment_amount',
        'balance_amount',

        [
            'attribute' => 'payment_date',
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'payment_date',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
            ]),
        ],

        'loss_amount',
    ],
]); ?>

<?php Pjax::end(); ?>
