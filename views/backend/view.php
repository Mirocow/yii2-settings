<?php 

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="settings-view">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p><?php echo $this->context->getUpdateButton($model); ?> <?php echo $this->context->getDeleteButton($model); ?></p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'key',
            'name',
            [
                'attribute' => 'type',
                'value' => $model->typeName,
            ],
            [
                'attribute' => 'value',
                'format' => 'raw',
                'value' => print_r($model->value, TRUE),
            ],
        ],
    ]); ?>

</div>
