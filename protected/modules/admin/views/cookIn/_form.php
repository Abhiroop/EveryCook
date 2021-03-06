<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cook-in-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo $this->trans->CREATE_REQUIRED; ?></p>
	<?php
	echo $form->errorSummary($model);
	if ($this->errorText){
			echo '<div class="errorSummary">';
			echo $this->errorText;
			echo '</div>';
	}
	
	foreach($this->allLanguages as $lang=>$name){
	echo '<div class="row">'."\r\n";
		echo $form->labelEx($model,'COI_DESC_'.$lang) ."\r\n";
		echo $form->textField($model,'COI_DESC_'.$lang,array('size'=>60,'maxlength'=>100)) ."\r\n";
		echo $form->error($model,'COI_DESC_'.$lang) ."\r\n";
	echo '</div>'."\r\n";
	}
	
	
	$htmlOptions_type0 = array('empty'=>$this->trans->GENERAL_CHOOSE);
	echo CHtml::link($this->trans->GENERAL_CREATE_NEW, array('tools/create',array('newModel'=>time())), array('class'=>'button f-right'));
	echo Functions::createInput(null, $model, 'TOO_ID', $tools, Functions::DROP_DOWN_LIST, 'tools', $htmlOptions_type0, $form);
	/*
	<div class="row">
		<?php echo $form->labelEx($model,'TOO_ID'); ?>
		<?php echo $form->textField($model,'TOO_ID'); ?>
		<?php echo $form->error($model,'TOO_ID'); ?>
	</div>
	
	*/
	?>
	

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? $this->trans->GENERAL_CREATE : $this->trans->GENERAL_SAVE); ?>
		<?php echo CHtml::link($this->trans->GENERAL_CANCEL, array('cancel'), array('class'=>'button', 'id'=>'cancel')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->