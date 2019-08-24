<?php 

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use mirocow\settings\models\Settings;

$this->title = 'Настройки';
$this->params['breadcrumbs'][] = $this->title;

$model = new Settings;

?>

<div class="settings-index">

    <h1><?php echo Html::encode($this->title); ?></h1>

    <p><?php echo $this->context->getCreateButton(); ?></p>

<?php Pjax::begin(); ?>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        //'id',
        [
            'attribute' => 'id',
            'format' => 'raw',
            'headerOptions' => ['width' => '50px'],
        ],
        'key',
        'name',
        [
            'attribute' => 'value',
            'format'    => 'raw',
            'value'     => function ($model) {
                return !is_array($model->value)? $model->value: '[Array]';
            },
        ],
        [
            'attribute' => 'group_name',
            'format'    => 'raw',
            'filter' => $model->groups,
            'value'     => function ($model) {

                return $model->group_name? $model->group_name: 'default';
            },
        ],
        [
            'attribute' => 'type',
            'filter' => $model->typeList,
            'value' => function($data){
                return $data->typeName;
            },
        ],

        $this->context->getActionColumn(),
    ],
]); ?>

<?php Pjax::end(); ?>

</div>
