<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;

$this->title = 'Claims Grid';
?>

<h2><?= Html::encode($this->title) ?></h2>

<!-- GRID CONFIG PANEL -->
<?= $this->render('_grid_config', [
    'allColumns'     => $allColumns,
    'columnsConfig' => $columnsConfig,
]) ?>

<?php Pjax::begin(['id' => 'claims-grid']); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered table-striped'],
    'columns' => array_filter(array_merge([

        // Expand icon column
        [
            'class' => 'yii\grid\Column',
            'header' => '',
            'content' => function ($model) {
                return Html::a('▼', 'javascript:void(0)', [
                    'class' => 'expand-row',
                    'data-details' => $model['details'] ?? 'No details',
                ]);
            }
        ],

    ], array_map(function ($key, $col) use ($columnsConfig, $searchModel) {

        if (empty($columnsConfig[$key])) {
            return null;
        }

        if (in_array($key, ['invoice_date', 'payment_date'])) {
            return [
                'attribute' => $key,
                'label' => $col['label'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => $key,
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                ]),
            ];
        }

        return [
            'attribute' => $key,
            'label' => $col['label'],
        ];

    }, array_keys($allColumns), $allColumns))),

]); ?>

<?php Pjax::end(); ?>

<?php
$js = <<<JS
// Expand row (PJAX safe)
$(document).on('click', '.expand-row', function () {
    let row = $(this).closest('tr');
    let details = $(this).data('details');

    $('.details-row').not(row.next()).remove();

    if (row.next().hasClass('details-row')) {
        row.next().remove();
    } else {
        row.after(
            '<tr class="details-row">' +
            '<td colspan="20"><strong>Details:</strong> ' + details + '</td>' +
            '</tr>'
        );
    }
});
JS;

$this->registerJs($js, View::POS_READY);
