<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TextField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';
    public $defaultOptions = [
        'maxlength' => TRUE,
        'rows' => 12,
    ];
    public $options = [];

    public function run()
    {
        $options = ArrayHelper::merge($this->defaultOptions, $this->options);
        $widget = reset(self::$stack);
        return $widget->field($this->model, $this->attribute, [
            'template' => "{input}\n{hint}"
        ])->textarea($options);
    }

}
