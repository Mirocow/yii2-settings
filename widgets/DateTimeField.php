<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;
use dosamigos\datetimepicker\DateTimePicker;
use yii\helpers\ArrayHelper;

class DateTimeField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';
    public $defaultOptions = [
        'language' => 'ru',
        'size' => 'ms',
        'template' => '{input}',
        'pickButtonIcon' => 'glyphicon glyphicon-time',
        'clientOptions' => [
            'autoclose' => TRUE,
            'format' => 'yyyy-mm-dd HH:ii:ss',
            'todayBtn' => TRUE,
        ],
    ];
    public $options = [];

    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        $widget = reset(self::$stack);
        return $widget->field($this->model, $this->attribute, [
            'template' => "{input}\n{hint}"
        ])->widget(DateTimePicker::className(), $options);
    }

}
