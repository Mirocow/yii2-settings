<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;

class SwitchField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';
    public $defaultOptions = [
        'type' => SwitchInput::CHECKBOX,
        'pluginOptions' => [
            'size' => 'large',
            'onColor' => 'success',
            'onText' => 'Да',
            'offColor' => 'danger',
            'offText' => 'Нет',
        ]
    ];
    public $options = [];

    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        $widget = reset(self::$stack);
        return $widget->field($this->model, $this->attribute, [
            'template' => "{input}\n{hint}"
        ])->widget(SwitchInput::className(), $options);
    }

}
