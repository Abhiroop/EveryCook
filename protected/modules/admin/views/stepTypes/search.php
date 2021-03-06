<?php
$this->breadcrumbs=array(
	'Step Types',
);

$this->menu=array(
	array('label'=>'Create StepTypes', 'url'=>array('create')),
	array('label'=>'Manage StepTypes', 'url'=>array('admin')),
);

if (!$this->isFancyAjaxRequest){
	//if ($this->validSearchPerformed){
		$this->mainButtons = array(
			array('label'=>$this->trans->GENERAL_CREATE_NEW, 'link_id'=>'middle_single', 'url'=>array('create',array('newModel'=>time()))),
		);
	//}
}

$advanceSearch = array(($this->isFancyAjaxRequest)?'advanceChooseIngredient':'advanceSearch');
if (isset(Yii::app()->session['StepTypes']) && isset(Yii::app()->session['StepTypes']['time'])){
	$advanceSearch=array_merge($advanceSearch,array('newSearch'=>Yii::app()->session['StepTypes']['time']));
}

if ($this->isFancyAjaxRequest){ ?>
	<input type="hidden" id="FancyChooseSubmitLink" value="<?php echo $this->createUrl('chooseStepTypes'); ?>"/>
	<?php
}
?>


<div>
<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'id'=>'step-types_form',
		'method'=>'post',
		'htmlOptions'=>array('class'=>($this->isFancyAjaxRequest)?'fancyForm':''),
	)); ?>
	<div class="f-left search">
		<?php if ($model2->query == ''){
			echo Functions::activeSpecialField($model2, 'query', 'search', array('class'=>'search_query', 'autofocus'=>'autofocus'));
		} else {
			echo Functions::activeSpecialField($model2, 'query', 'search', array('class'=>'search_query'));
		} ?>
		<?php echo CHtml::imageButton(Yii::app()->request->baseUrl . '/pics/search.png', array('class'=>'search_button', 'title'=>$this->trans->GENERAL_SEARCH)); ?>
	</div>
	
	<?php /*
	<div class="f-right">
		<?php  echo CHtml::link($this->trans->GENERAL_ADVANCE_SEARCH, $advanceSearch, array('class'=>'button', 'id'=>'advanceSearch')); ?><br>
	</div>
	*/ ?>
	
	<div class="f-center">
		<?php  echo CHtml::link($this->trans->GENERAL_CREATE_NEW, array('create','newModel'=>time()), array('class'=>'button', 'id'=>'create')); ?><br>
	</div>
	
	<div class="clearfix"></div>

<?php  $this->widget('AjaxPagingListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_array',
	'ajaxUpdate'=>false,
	'id'=>'ingredientsResult',
)); 
?>
<?php $this->endWidget(); ?>

</div>