<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;

class StringField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';
    public $defaultOptions = [
        'maxlength' => TRUE,
    ];
    public $options = [];

    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        $widget = reset(self::$stack);
        return $widget->field($this->model, $this->attribute, [
            'template' => "{input}\n{hint}"
        ])->textInput($options);
    }

}
