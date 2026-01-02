<?php
use yii\helpers\Html;
?>

<div id="grid-config-panel"
     style="margin-bottom:10px; padding:10px; border:1px solid #ccc;">
    <h5>Grid Configuration</h5>

    <?php foreach ($columns as $key => $column): ?>
        <label style="margin-right:15px;">
            <?= Html::checkbox(null, $column['visible'], [
                'class' => 'toggle-column',
                'data-col-label' => $column['label'],   // used for matching TH
            ]) ?>
            <?= Html::encode($column['label']) ?>
        </label>
    <?php endforeach; ?>
</div>
