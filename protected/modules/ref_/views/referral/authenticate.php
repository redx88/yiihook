<?php
/* @var $this ReferralController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Referrals',
);

$this->menu=array(
	array('label'=>'Create Referral', 'url'=>array('create')),
	array('label'=>'Manage Referral', 'url'=>array('admin')),
);
?>
<?php $image=Yii::app()->baseUrl.('/images/ajax-loader.gif');?>

<?php 
Yii::app()->clientScript->registerScript('connect', "
	
	$('.apiconnect-form form').submit(function(){
		
		//$('#grid-accomplishment').yiiGridView('update', {
			//data: $(this).serialize(),
			//beforeSend: function(){
				  //var overlay = new ItpOverlay('grid-accomplishment');
	        	  //overlay.show();
			//}
		//});
		//return false;
		alert('hahahaha');
	});
");
?>


<h1 'style'='text-align: center;' >Welcome to ULIMS Referral Module</h1>
<hr/>
<br/>
<?php //echo $apiLogin ? 'True' : 'False';?>

<div class="form wide">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'apiconnect-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	//'action'=>Yii::app()->createUrl($this->route),
));	
?>
	<div class="row">
		<?php //echo $form->labelEx($model,'receivedBy'); ?>
		<?php //echo $form->textField($model,'receivedBy',array('size'=>50,'maxlength'=>50, 'value'=>Yii::app()->getModule('user')->user()->getFullName())); ?>
		<?php //echo $form->error($model,'receivedBy'); ?>
		<?php echo CHtml::textField('agency_id', Yii::app()->Controller->RstlId, array('style'=>'display: none;')); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Connect', 
			array(	'class'=>$btnClass, 
					'style'=>'width: 375px; height: 75px; font-size: 250%; font-weight: bold',
					'disabled'=>$apiLogin ? false : true,
					'onClick'=>$apiLogin ? '' : 'js:{return false;}'
			)); ?>
			
			<?php if(Yii::app()->user->hasFlash('apiLogin')): ?>
			    <div class="<?php echo $alertClass;?>" style="width:325px;">
					<strong> <?php echo Yii::app()->user->getFlash('apiLogin'); ?> </strong> <br/>
				</div>
			<?php endif; ?>
			
			<!--div class="progress progress-striped active">
		    	<div class="bar" style="width: 25%;"></div>
		    </div-->
	</div>

<?php $this->endWidget(); ?>

<?php //echo Yii::app()->Controller->getServer();
//echo '<br/>'.Yii::app()->Controller->RstlId.'<br/>'.Yii::app()->user->name;
			/*$user = User::model()->notsafe()->findByAttributes(array('username'=>Yii::app()->user->name));
			$username = $user->username;
			$password = $user->password;	
			
			$id = Yii::app()->Controller->RstlId;
			$apiHost = Yii::app()->Controller->getServer().'/users/accesstoken?id='.$id;
			
			$auth = array(
				'Authorization: Basic '.base64_encode($username . ':' . $password),
				'auth_key: '.SHA1(rand(1,999999999)),
				'email: '.$user->email
				//'agency: '.$user->role
			);
			$response = Yii::app()->curl->setOptions(array(CURLOPT_HTTPHEADER => $auth))->get($apiHost);
			
			print_r(json_decode($response));
			//print_r($auth);*/
			//print_r($user);
			//echo '<br/>';
			//echo $user->username;
			//print_r(json_decode(RestController::verifyAgencyKey(11)));
			//print_r(json_decode($response));
			//echo $apiLogin;
			//print_r(json_decode($response));
?>

</div><!-- form -->
<br/>
<hr/>
<pre>
<?php print_r($apiLogin); ?>
</pre>
