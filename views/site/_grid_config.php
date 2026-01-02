<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="card mb-3">
    <div class="card-header"><strong>Grid Configuration</strong></div>
    <div class="card-body">
        <?php foreach ($allColumns as $key => $col): ?>
            <div class="form-check form-switch mb-2">
                <input class="form-check-input grid-toggle"
                       type="checkbox"
                       data-column="<?= $key ?>"
                       <?= !empty($columnsConfig[$key]) ? 'checked' : '' ?>>
                <label class="form-check-label">
                    <?= Html::encode($col['label']) ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$saveUrl = Url::to(['site/save-grid-config']);
$js = <<<JS
$('.grid-toggle').on('change', function () {
    let config = {};
    $('.grid-toggle').each(function () {
        config[$(this).data('column')] = $(this).is(':checked') ? 1 : 0;
    });

    $.post('$saveUrl', {columns: config}, function () {
        $.pjax.reload({container: '#claims-grid'});
    });
});
JS;

$this->registerJs($js);
