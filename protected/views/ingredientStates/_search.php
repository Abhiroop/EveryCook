<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'IST_ID'); ?>
		<?php echo $form->textField($model,'IST_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IST_DESC_EN'); ?>
		<?php echo $form->textField($model,'IST_DESC_EN',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IST_DESC_DE'); ?>
		<?php echo $form->textField($model,'IST_DESC_DE',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->