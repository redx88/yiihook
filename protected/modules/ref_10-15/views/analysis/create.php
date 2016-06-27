<?php
/* @var $this AnalysisController */
/* @var $model Analysis */

$this->breadcrumbs=array(
	'Analysises'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Analysis', 'url'=>array('index')),
	array('label'=>'Manage Analysis', 'url'=>array('admin')),
);
?>

<h1>Create Analysis</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>