<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

    <?php if($model->isNewRecord):?>
        <?= $form->field($model, 'type')->dropDownList($model->typeList); ?>
    <?php else:?>
        <?= $model->getTypeWidget($this, $form) ?>
    <?php endif;?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true, 'value' => $model->group_name? $model->group_name: 'default']); ?>

    <div class="form-group">
        <?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success', ]); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
