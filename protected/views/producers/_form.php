<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'producers-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>($this->isFancyAjaxRequest)?'fancyForm':''),
)); ?>

	<p class="note"><?php echo $this->trans->CREATE_REQUIRED; ?></p>

	<?php
	echo $form->errorSummary($model);
	if ($this->errorText){
		echo '<div class="errorSummary">';
		echo $this->errorText;
		echo '</div>';
	}
	?>

	<div class="row">
		<?php echo $form->labelEx($model,'PRD_NAME'); ?>
		<?php echo $form->textField($model,'PRD_NAME',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'PRD_NAME'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? $this->trans->GENERAL_CREATE : $this->trans->GENERAL_SAVE); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->