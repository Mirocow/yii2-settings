<?php 

namespace mirocow\settings\widgets;

use Yii;
use yii\bootstrap\Widget;
use dosamigos\tinymce\TinyMce;
use fileManager\Module as FileManagerModule;
use yii\helpers\ArrayHelper;

class HTMLField extends Widget
{

    public $view;
    public $form;
    public $model;
    public $attribute = 'value';
    public $defaultOptions = [
        'options' => ['rows' => 12],
        'language' => 'ru',
        'clientOptions' => [],
    ];
    public $options = [];

    public function run()
    {
        $file_picker_callback = '';

        if(isset(FileManagerModule::$instance)) {
            $file_picker_callback = [ 'file_picker_callback' => \alexantr\elfinder\TinyMCE::getFilePickerCallback(Yii::$app->urlManager->createUrl([ FileManagerModule::$instance->id.'/elfinder/tinymce' ])) ];
        }

        $options = ArrayHelper::merge($this->defaultOptions, [
            'clientOptions' => [
                'plugins' => [
                    'advlist autolink lists link charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen textcolor',
                    'insertdatetime media table contextmenu paste image',
                ],
                'toolbar' => 'undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media',
                $file_picker_callback,
                'extended_valid_elements' => 'b,i,b/strong,i/em',
            ]
        ]);

        $options = ArrayHelper::merge($options, $this->options);
        $widget = reset(self::$stack);
        return $widget->field($this->model, $this->attribute, [
            'template' => "{input}\n{hint}"
        ])->widget(TinyMce::className(), $options);
    }

}
