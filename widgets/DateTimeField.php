<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;
use dosamigos\datetimepicker\DateTimePicker;

class DateTimeField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';

    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->widget(DateTimePicker::className(), [
            'language' => 'ru',
            'size' => 'ms',
            'template' => '{input}',
            'pickButtonIcon' => 'glyphicon glyphicon-time',
            'clientOptions' => [
                'autoclose' => TRUE,
                'format' => 'yyyy-mm-dd HH:ii:ss',
                'todayBtn' => TRUE,
            ],
        ]);
    }

}
