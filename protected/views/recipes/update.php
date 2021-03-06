<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	$model->REC_ID=>array('view','id'=>$model->REC_ID),
	'Update',
);

$this->menu=array(
	array('label'=>'List Recipes', 'url'=>array('index')),
	array('label'=>'Create Recipes', 'url'=>array('create')),
	array('label'=>'View Recipes', 'url'=>array('view', 'id'=>$model->REC_ID)),
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);
?>

<h1><?php printf($this->trans->TITLE_RECIPES_UPDATE, $model->REC_ID); ?></h1>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'recipeTypes'=>$recipeTypes,
	'actionsIn'=>$actionsIn,
	'cookIns'=>$cookIns,
	'cookInsSelected'=>$cookInsSelected,
	'tools'=>$tools,
	'ingredients'=>$ingredients,
	'stepsJSON'=>$stepsJSON,
	'actionsInDetails'=>$actionsInDetails,
	)); ?>