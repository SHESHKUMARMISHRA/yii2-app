<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\jui\DatePicker;

$this->title = 'Claims Grid';
?>

<h3><?= Html::encode($this->title) ?></h3>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel, // <-- important
    'tableOptions' => ['class' => 'table table-bordered table-striped'],
    'columns' => [
        [
            'class' => 'yii\grid\Column',
            'header' => '',
            'content' => function ($model) {
                return Html::a('▼', 'javascript:void(0)', [
                    'class' => 'expand-row',
                    'data-id' => $model['id'],
                    'data-details' => $model['details'] ?? '',
                ]);
            }
        ],

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
            'filter' => \yii\jui\DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'payment_date',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
            ]),
        ],

        'loss_amount',
    ],
]); ?>


<?php
$js = <<<JS
$('.expand-row').on('click', function () {
    let row = $(this).closest('tr');
    let details = $(this).data('details') || 'No details';

    // Collapse any other expanded rows
    $('.details-row').not(row.next('.details-row')).remove();

    // Toggle current row
    let detailsRow = row.next('.details-row');
    if (detailsRow.length) {
        detailsRow.remove();
    } else {
        row.after(
            '<tr class="details-row">' +
            '<td colspan="14"><strong>Details:</strong> ' + details + '</td>' +
            '</tr>'
        );
    }
});
JS;


$this->registerJs($js, View::POS_READY);
?>
