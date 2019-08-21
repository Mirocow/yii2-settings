<?php 

namespace mirocow\settings\widgets;

use yii\bootstrap\Widget;

class TextField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';

    public function run()
    {
        return $this->form->field($this->model, $this->attribute)->textarea(['maxlength' => TRUE, 'rows' => 12, ]);
    }

}
