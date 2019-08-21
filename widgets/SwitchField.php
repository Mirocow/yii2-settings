<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;
use kartik\switchinput\SwitchInput;

class SwitchField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';

    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->widget(SwitchInput::className(), [
            'type' => SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'size' => 'large',
                'onColor' => 'success',
                'onText' => 'Да',
                'offColor' => 'danger',
                'offText' => 'Нет',
            ]
        ]);
    }

}
