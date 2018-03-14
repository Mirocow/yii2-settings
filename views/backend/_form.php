<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?php echo $model->isNewRecord ? $form->field($model, 'type')->dropDownList($model->typeList) : $model->getTypeWidget($this, $form); ?>

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success', ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
