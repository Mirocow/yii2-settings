<?php 

namespace mirocow\settings\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\web\View;

class ArrayField extends Widget
{

    public $view;
    public $model;
    public $attribute = 'value';
    public $defaultOptions = [
        'data-selector' => 'array-field',
        'style' => 'margin-bottom: 10px;',
        'id' => FALSE,
    ];
    public $options = [];

    public function run()
    {
        $this->view->registerJs('
$(document).ready(function(){
    var arrayFieldChangeHandler = function(){
        var parent = $(this).parent();
        if($(this).val() == \'\'){
            $(this).addClass(\'empty-field\').removeClass(\'filled-field\');
            if($(\'.empty-field[data-selector="array-field"]\').length > 1){
                parent.remove();
            }
        }else{
            $(this).addClass(\'filled-field\').removeClass(\'empty-field\');
            if($(\'.empty-field[data-selector="array-field"]\').length < 1){
                var newElem = parent.clone();
                newElem.find(\'input\').addClass(\'empty-field\').removeClass(\'filled-field\').val(\'\').change(arrayFieldChangeHandler);
                $(document).find(\'[data-selector="array-field"]\').last().parent().after(newElem);
            }
        }
    };

    $(\'[data-selector="array-field"]\').each(function(){
        $(this).attr(\'name\', $(this).attr(\'name\') + \'[]\');
        $(this).change(arrayFieldChangeHandler);
    });

    $(\'form\').submit(function(){
        $(\'.empty-field[data-selector="array-field"]\').parent().remove();
        return true;
    });
});
', View::POS_END, 'ArrayField');

        $realValue = $this->model->{$this->attribute};

        $result = '';

        foreach(((array) $this->model->{$this->attribute} + ['empty-field' => '', ]) as $index => $item){
            $this->model->{$this->attribute} = $item;
            $options = ArrayHelper::merge($this->defaultOptions, [
                'data-selector' => 'array-field',
                'class' => 'form-control ' . (empty($this->model->{$this->attribute}) ? 'empty-field' : 'filled-field'),
                'style' => 'margin-bottom: 10px;',
                'id' => FALSE,
            ]);
            $options = ArrayHelper::merge($options, $this->options);
            $widget = reset(self::$stack);
            $result .= $widget->field($this->model, $this->attribute, [
                'template' => "{input}\n{hint}"
            ])->textInput($options);
        }

        $this->model->{$this->attribute} = $realValue;

        return $result;
    }

}
