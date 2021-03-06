<?php
$this->breadcrumbs=array(
	'Recipes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Recipes', 'url'=>array('index')),
	array('label'=>'Manage Recipes', 'url'=>array('admin')),
);
?>

<h1><?php echo $this->trans->TITLE_RECIPES_CREATE; ?></h1>

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