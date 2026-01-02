<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

$this->title = 'Claims Grid';
?>

<?= $this->render('_grid_config', [
    'columnsConfig' => $columnsConfig,
    'allColumns' => $allColumns,
]) ?>

<h3><?= Html::encode($this->title) ?></h3>

<?php
/* -------------------------
   Build Dynamic Grid Columns
   ------------------------- */
$gridColumns = [];

/* Expand icon column */
$gridColumns[] = [
    'class' => 'yii\grid\Column',
    'header' => '',
    'content' => function ($model) {
        return Html::a('▼', 'javascript:void(0)', [
            'class' => 'expand-row',
            'data-details' => $model['details'] ?? 'No details',
        ]);
    }
];

/* Dynamic columns from config */
foreach ($allColumns as $key => $col) {
    if (empty($columnsConfig[$key])) {
        continue;
    }

    if (in_array($key, ['invoice_date', 'payment_date'])) {
        $gridColumns[] = [
            'attribute' => $key,
            'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => $key,
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
            ]),
        ];
    } else {
        $gridColumns[] = [
            'attribute' => $key,
            'filter' => Html::activeTextInput(
                $searchModel,
                $key,
                ['class' => 'form-control']
            ),
        ];
    }
}
?>

<?php Pjax::begin(['id' => 'claims-grid']); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'tableOptions' => ['class' => 'table table-bordered table-striped'],
    'columns'      => $gridColumns,
]); ?>

<?php Pjax::end(); ?>

<?php
$js = <<<JS
$(document).on('click', '.expand-row', function () {
    let row = $(this).closest('tr');
    let details = $(this).data('details') || 'No details';

    $('.details-row').not(row.next()).remove();

    if (row.next().hasClass('details-row')) {
        row.next().remove();
    } else {
        row.after(
            '<tr class="details-row">' +
            '<td colspan="100%"><strong>Details:</strong> ' + details + '</td>' +
            '</tr>'
        );
    }
});
JS;

$this->registerJs($js, View::POS_READY);
?>
