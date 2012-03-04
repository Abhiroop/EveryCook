<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'producers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'PRD_NAME'); ?>
		<?php echo $form->textField($model,'PRD_NAME',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'PRD_NAME'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->