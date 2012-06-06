<?php
$this->breadcrumbs=array(
	'Profiles'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Profiles', 'url'=>array('index')),
	array('label'=>'Create Profiles', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('profiles-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Profiles</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'profiles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'PRF_UID',
		'PRF_FIRSTNAME',
		'PRF_LASTNAME',
		'PRF_NICK',
		'PRF_GENDER',
		'PRF_BIRTHDAY',
		/*
		'PRF_EMAIL',
		'PRF_LANG',
		'PRF_IMG',
		'PRF_PW',
		'PRF_LOC_GPS_LAT',
		'PRF_LOC_GPS_LNG',
		'PRF_LOC_GPS_POINT',
		'PRF_LIKES_I',
		'PRF_LIKES_R',
		'PRF_LIKES_P',
		'PRF_LIKES_S',
		'PRF_NOTLIKES_I',
		'PRF_NOTLIKES_R',
		'PRF_NOTLIKES_P',
		'PRF_SHOPLISTS',
		'PRF_ACTIVE',
		'PRF_RND',
		'CREATED_BY',
		'CREATED_ON',
		'CHANGED_BY',
		'CHANGED_ON',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
