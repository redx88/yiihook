<?php
/* @var $this ReferralController */
/* @var $model Referral */

$this->menu=array(
	array('label'=>'Create Referral', 'url'=>array('create')),
	array('label'=>'Update Referral', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Manage Referral', 'url'=>array('admin')),
);
?>

<h1>View Referral: <?php echo $referral['referralCode']; ?><small>
<?php //echo $model->cancelled ? '' : (Yii::app()->getModule('lab')->isLabAdmin() ? $linkCancelWithReason : '');?>
</small>
</h1>
<?php 
	$this->widget('ext.widgets.DetailView4Col', array(
	'cssFile'=>false,
	'htmlOptions'=>array('class'=>'detail-view table table-striped table-condensed'),
	'data'=>$referral,
	'attributes'=>array(
		array(
            'name'=>'referralDetails',
            'oneRow'=>true,
			'cssClass'=>'title-row',
            'type'=>'raw',
            'value'=>'',
        ),	
        
		'referralCode',
		array(
			'name' => 'Customer / Agency',
			'type'=>'raw',
            'value'=>$referral['customer']['customerName'],
		), 
        
		'referralDate', 
		array(
			'name' => 'Address',
			'type'=>'raw',
            'value'=>$referral['customer']['houseNumber'],
		), 
		
		'referralTime', 
		
		array(
			'name' => 'tel',
			'type'=>'raw',
            'value'=>$referral['customer']['tel'],
		),
		
		'reportDue', 
		
		array(
			'name' => 'fax',
			'type'=>'raw',
            'value'=>$referral['customer']['fax'],
		),
		
		array(
            'name'=>'paymentDetails',
            'oneRow'=>true,
			'cssClass'=>'title-row',
            'type'=>'raw',
            'value'=>'',
        ),

        array(
        	'name' => 'ORs',
        	'label' => 'ORs'
        ),
        
        'collection',
        
        array(
        	'name' => 'ORDates',
        	'label' => 'OR Dates'
        ),
        
        'unpaidBalance',
        
        array(
            'name'=>'transactionDetails',
            'oneRow'=>true,
			'cssClass'=>'title-row',
            'type'=>'raw',
            'value'=>'',
        ),
        
        'receivedBy',
        'conforme'
	),
));
?>

<br/>

<?php	$linkSample = Chtml::link('<span class="icon-white icon-plus-sign"></span> Add Sample', '', array( 
			'style'=>'cursor:pointer;',
			'class'=>'btn btn-info',
			'onClick'=>'js:{addSample('.$_GET["id"].', '.$referral["lab_id"].'); $("#dialogSample").dialog("open");}',
			));
			
		$linkAnalysis = Chtml::link('<span class="icon-white icon-plus-sign"></span> Add Analysis', '', array( 
			'style'=>'cursor:pointer;',
			'onClick'=>'js:{addAnalysis('.$_GET["id"].'); $("#dialogAnalysis").dialog("open");}',
			'class'=>'btn btn-info',
			));
			
		$linkPackagedTests = Chtml::link('<span class="icon-white icon-plus-sign"></span> Add Packaged Tests', '', array( 
			'style'=>'cursor:pointer;',
			'onClick'=>'js:{addTest('.$referral["acceptingLabId"].', '.$_GET["id"].'); $("#dialogTest").dialog("open");}',
			'class'=>'btn btn-info',
			));
		$display = Referral::owner($referral["receivingAgencyId"]) ? '' : 'display:none';
		echo '<div style="text-align: center; '.$display.'">'.$linkSample.'&nbsp;&nbsp;&nbsp;';
		echo $linkAnalysis.'&nbsp;&nbsp;&nbsp;'.$linkPackagedTests.'</div>';
?>
<h4 style="margin-bottom: -15px;">Samples</h4>
<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'sample-grid',
	    'summaryText'=>false,
		'emptyText'=>'No samples.',
		//'htmlOptions'=>array('class'=>'grid-view padding0 paddingLeftRight10'),
        //'rowCssClassExpression'=>'$data->status',
		'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
		'rowHtmlOptionsExpression' => 'array("title" => "Click to update", "class"=>"link-hand")', 
        //It is important to note, that if the Table/Model Primary Key is not "id" you have to
        //define the CArrayDataProvider's "keyField" with the Primary Key label of that Table/Model.
        'dataProvider' => $samples,
        'columns' => array(
			array(
    			'name'=>'barcode',
				'header'=>'Barcode',
    			'value'=>'CHtml::encode($data["barcode"])',
    			'htmlOptions' => array('style' => 'width: 150px; text-align: center;'),
    		),
			array(
				'name'=>'sampleCode',
				'header'=>'Sample Code',
				'value'=>'CHtml::encode($data["sampleCode"])',
				'htmlOptions' => array('style' => 'width: 150px; text-align: center;'),
			),
			array(
				'name'=>'sampleName',
				'header'=>'Sample Name',
				'value'=>'CHtml::encode($data["sampleName"])',
				'htmlOptions' => array('style' => 'width: 200px; padding-left: 10px; text-align: left;'),
			),
    		array(
				'name'=>'description',
				'header'=>'Description',
				'type'=>'raw',
				'value'=>'CHtml::encode($data["description"])'
			),
			array(
				'header'=>'Actions',
				'class'=>'bootstrap.widgets.TbButtonColumn',
						'deleteConfirmation'=>"js:'Do you really want to delete sample: '+$.trim($(this).parent().parent().children(':nth-child(3)').text())+' and all its analyses?'",
						'template' => '{delete}',
						//'template'=>($generated >= 1) ? '{delete}' : (Yii::app()->getModule('lab')->isLabAdmin() ? '{cancel}' : ''),
						'buttons'=>array
						(
							'delete' => array(
								'label'=>'Delete Analysis',
								'url'=>'Yii::app()->createUrl(\'ref/sample/delete\', array(\'id\'=>$data["id"]))',
								'visible'=>'Referral::owner('.$referral["receivingAgencyId"].')',								
							),
						),
			)
        )
    ));
    ?>
<h4 style="margin-top: -20px; margin-bottom: -15px;">Analyses</h4>
<?php 
    $this->widget('zii.widgets.grid.CGridView', array(
    	'id'=>'analysis-grid',
	    'summaryText'=>false,
		'emptyText'=>'No analyses.',
		//'htmlOptions'=>array('class'=>'grid-view padding0 paddingLeftRight10'),
		'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
		'rowHtmlOptionsExpression' => 'array("title" => "Click to update", "class"=>"link-hand")', 
        //It is important to note, that if the Table/Model Primary Key is not "id" you have to
        //define the CArrayDataProvider's "keyField" with the Primary Key label of that Table/Model.
        'dataProvider' => $analyses,
        'columns' => array(
    		//'id',
    		array(
				'name'=>'sampleName',
				'header'=>'Sample Name',
    			'htmlOptions' => array('style' => 'width: 175px; padding-left: 10px; text-align: left;'),
			),
			array(
				'name'=>'testName',
				'header'=>'Test Name',
				'htmlOptions' => array('style' => 'width: 175px; padding-left: 10px; text-align: left;'),
			),
			array(
				'name'=>'method',
				'header'=>'Method',
				'htmlOptions' => array('style' => 'width: 300px; padding-left: 10px; text-align: left;'),
			),
			array(
				'name'=>'reference',
				'header'=>'Reference',
				'htmlOptions' => array('style' => 'width: 175px; padding-left: 10px; text-align: center;'),
				'footer'=>'SUBTOTAL<br/>DISCOUNT<br/><b>TOTAL</b>',
				'footerHtmlOptions'=>array('style'=>'text-align: right; padding-right: 10px;'),
			),
			array(
				'name'=>'fee',
				'header'=>'Fee',
				'value'=>'Yii::app()->format->formatNumber($data["fee"])',
				'htmlOptions' => array('style' => 'width: 75px; padding-right: 20px; text-align: right;'),
			),
			array(
			'header'=>'Actions',
			'class'=>'bootstrap.widgets.TbButtonColumn',
						'deleteConfirmation'=>"js:'Do you really want to delete analysis: '+$.trim($(this).parent().parent().children(':nth-child(3)').text())+'?'",
						'template' => '{delete}',
						//'template'=>($generated >= 1) ? '{delete}' : (Yii::app()->getModule('lab')->isLabAdmin() ? '{cancel}' : ''),
						'buttons'=>array
						(
							'delete' => array(
								'label'=>'Delete Analysis',
								'url'=>'Yii::app()->createUrl(\'ref/analysis/delete\', array(\'id\'=>$data["id"]))',
								'visible'=>'Referral::owner('.$referral["receivingAgencyId"].')',
								),
						),
			)
    		
        ),
    ));
?>
<?php if($referral['acceptingAgencyId'] == 0){?>
	
	<?php $linkSearchAgency = Chtml::link('<span class="icon-white icon-plus-sign"></span> Search Available Agencies', '', array( 
			'style'=>'cursor:pointer;',
			'class'=>'btn btn-info',
			'onClick'=>'js:{searchAgency('.$_GET["id"].');}',
			));

			echo '<div style="text-align: center">'.$linkSearchAgency.'</div>';
	?>
			
	<?php 
	    $this->widget('zii.widgets.grid.CGridView', array(
	    	'id'=>'agency-grid',
		    'summaryText'=>false,
			'emptyText'=>'No matching Agency',
			//'htmlOptions'=>array('class'=>'grid-view padding0 paddingLeftRight10'),
			'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
			'rowHtmlOptionsExpression' => 'array("title" => "Click to update", "class"=>"link-hand")', 
	        //It is important to note, that if the Table/Model Primary Key is not "id" you have to
	        //define the CArrayDataProvider's "keyField" with the Primary Key label of that Table/Model.
	        'dataProvider' => $matchingAgencies,
	        'columns' => array(
	    		array(
					'name'=>'name',
					'header'=>'Agency',
				),
	    		array(
					'name'=>'code',
					'header'=>'Region',
				),
				array(
					'name'=>'availableSlots',
					'header'=>'Available Slots',
				),
	        ),
	    ));
	?>
<?php }else{ ?>
	<h4 style="margin-top: -15px; margin-bottom: -15px;">Referral Status</h4>	
	<hr>
	
	<?php
	$this->widget('editable.EditableDetailView', array(
    'data'       => $modelStatus,
    //you can define any default params for child EditableFields 
    
    'params'     => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken), //params for all fields
    'emptytext'  => 'Not set', 
    'attributes' => array(
		'id',
		array(
			'name'=>'acceptingAgencyId',
			'label'		=> 'Referred To',
			'rowHtmlOptions' => array('style' => 'width: 550px; text-align: center;'),
			'editable' => array(
                'type'   	=> 'select',
				'source'	=> Referral::agencyLookUp('matchingAgencies', $acceptingAgencyLookup),
				'url'       => $this->createUrl('referralstatus/updateStatus'),
				'pk'		 => $modelStatus->id,
				//'apply'		=> 'Referral::owner($data["receivingAgencyId"])',
            )
		),
    	array(
			'name'=>'sampleArrivalDate',
			'editable' => array(
                'type'			=> 'date',
                'viewformat'	=> 'yyyy-mm-dd',
    			'url'       => $this->createUrl('referralstatus/updateStatus'),
				'pk'		 => $modelStatus->id,
            )
		),
		array(
			'name'=>'shipmentDetails',
			'editable' => array(
                'type'       => 'text',
				'url'       => $this->createUrl('referralstatus/updateStatus'),
				'pk'		 => $modelStatus->id,
                'inputclass' => 'input-large',
            )
		),
		array(
			'name'=>'status_id',
			'editable' => array(
                'type'   => 'select',
                //'source' => Referral::itemAlias('StatusReceivingRelease'),
                'source' => Referral::itemAlias('StatusAll'),
				'url'       => $this->createUrl('referralstatus/updateStatus'),
				'pk'		 => $modelStatus->id,
            )
		),
    )));
	}
?>

<!-- Referral Dialog : Start -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'dialogReferral',
		    // additional javascript options for the dialog plugin
		    'options'=>array(
		        'title'=>'Referral',
				'show'=>'scale',
				'hide'=>'scale',				
				'width'=>400,
				'modal'=>true,
				'resizable'=>false,
				'autoOpen'=>false,
			    ),
		));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- Referral Dialog : End -->   

<!-- Sample Dialog : Start -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'dialogSample',
		    // additional javascript options for the dialog plugin
		    'options'=>array(
		        'title'=>'Sample',
				'show'=>'scale',
				'hide'=>'scale',				
				'width'=>450,
				'modal'=>true,
				'resizable'=>false,
				'autoOpen'=>false,
			    ),
		));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- Sample Dialog : End -->    

<!-- Test Dialog : Start -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'dialogAnalysis',
		    // additional javascript options for the dialog plugin
		    'options'=>array(
		        'title'=>'Analysis',
				'show'=>'scale',
				'hide'=>'scale',				
				'width'=>550,
				'modal'=>true,
				'resizable'=>false,
				'autoOpen'=>false,
			    ),
		));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- Test Dialog : End -->

<!-- Search Agency Dialog : Start -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'dialogSearchAgency',
		    // additional javascript options for the dialog plugin
		    'options'=>array(
		        'title'=>'Search Agency',
				'show'=>'scale',
				'hide'=>'scale',				
				'width'=>350,
				'modal'=>true,
				'resizable'=>false,
				'autoOpen'=>false,
			    ),
		));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- Search Agency Dialog : End -->

<!-- Search Agency Dialog : Start -->
<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		    'id'=>'dialogSendReferral',
		    // additional javascript options for the dialog plugin
		    'options'=>array(
		        'title'=>'Send Referral',
				'show'=>'scale',
				'hide'=>'scale',				
				'width'=>425,
				'modal'=>true,
				'resizable'=>false,
				'autoOpen'=>false,
			    ),
		));

	$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- Search Agency Dialog : End -->

<?php
$image = CHtml::image(Yii::app()->request->baseUrl . '/images/ajax-loader.gif');
Yii::app()->clientScript->registerScript('clkrowgrid', "
$('#sample-grid table tbody tr').live('click',function()
{
	    var id = $.fn.yiiGridView.getKey(
        'sample-grid',
        $(this).prevAll().length 
    	);
    	
    	var owner = ".Referral::owner($referral['receivingAgencyId']).";
    	
		if($(this).children(':nth-child(1)').text()=='No samples.'){
			alert($(this).children(':nth-child(1)').text());
		}else{
			if(owner == 1){
				updateSample(id);
				$('#dialogSample').dialog('open');
			}else{
				return false;				
			}
		}
});
");

Yii::app()->clientScript->registerScript('clkrowgrid2', "
$('#analysis-grid table tbody tr').live('click',function()
{
	    var analysis_id = $.fn.yiiGridView.getKey(
        'analysis-grid',
        $(this).prevAll().length 
    	);
    	
    	var owner = ".Referral::owner($referral['receivingAgencyId']).";
    	
		if($(this).children(':nth-child(1)').text()=='No analyses.'){
			alert($(this).children(':nth-child(1)').text());
		}else{
			if(owner == 1){
				updateAnalysis(".$_GET['id'].", analysis_id);
				$('#dialogAnalysis').dialog('open');
			}else{
				return false;				
			}
		}
});
");

Yii::app()->clientScript->registerScript('clkrowgrid3', "
$('#agency-grid table tbody tr').live('click',function()
{
	    var id = $.fn.yiiGridView.getKey(
        'agency-grid',
        $(this).closest('tr').prevAll().length 
    	);
    	
    	var agencyName = $(this).children(':nth-child(1)').text();
    	var referralCode = '".$referral['referralCode']."';
    	
		if($(this).children(':nth-child(1)').text()=='No Matching Agency.'){
			alert($(this).children(':nth-child(1)').text());
		}else{
			sendReferral(id, agencyName, ".$_GET['id'].", referralCode);
			$('#dialogSendReferral').dialog('open');
		}
});
");
?>

<script type="text/javascript">
function addSample(referralId, lab_id)
{
    <?php 
    		echo CHtml::ajax(array(
			'url'=>$this->createUrl('sample/create'),
    		'data'=> "js:$(this).serialize()+ '&referralId='+referralId+ '&lab_id='+lab_id",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogSample').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#dialogSample form').submit(addSample);
                }
                else
                {
                    $.fn.yiiGridView.update('sample-grid');
					$('#dialogSample').html(data.div);
                    setTimeout(\"$('#dialogSample').dialog('close') \",1000);
					
                }
 
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogSample").html(
						\'<div class="loader">'.$image.'<br\><br\>Generating form.<br\> Please wait...</div>\'
					);
             }',
			 'error'=>"function(request, status, error){
				 	$('#dialogSample').html(status+'('+error+')'+': '+ request.responseText );
					}",
			
            ))?>;
    return false; 
}

function updateSample(id)
{
	<?php 
	echo CHtml::ajax(array(
			'url'=>$this->createUrl('sample/update'),
			'data'=> "js:$(this).serialize()+ '&id='+id",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogSample').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#dialogSample form').submit(updateSample);
                }
                else
                {
                    $.fn.yiiGridView.update('sample-grid');
                    $.fn.yiiGridView.update('analysis-grid');
					$('#dialogSample').html(data.div);
                    setTimeout(\"$('#dialogSample').dialog('close') \",1000);
                }
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogSample").html(
						\'<div class="loader">'.$image.'<br\><br\>Retrieving record.<br\> Please wait...</div>\'
					);
            }',
			 'error'=>"function(request, status, error){
				 	$('#dialogSample').html(status+'('+error+')'+': '+ request.responseText+ ' {'+error.code+'}' );
					}",
            ))?>;
    return false; 
}

function addAnalysis(referralId)
{
    <?php echo CHtml::ajax(array(
    		'url'=>$this->createUrl('analysis/create'),
    		'data'=> "js:$(this).serialize()+ '&referralId='+referralId",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogAnalysis').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#dialogAnalysis form').submit(addAnalysis);
                }
                else
                {
                    $.fn.yiiGridView.update('analysis-grid');
					$('#dialogAnalysis').html(data.div);
                    setTimeout(\"$('#dialogAnalysis').dialog('close') \",1000);
                }
 
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogAnalysis").html(
						\'<div class="loader">'.$image.'<br\><br\>Generating form.<br\> Please wait...</div>\'
					);
             }',
			 'error'=>"function(request, status, error){
				 	$('#dialogAnalysis').html(status+'('+error+')'+': '+ request.responseText );
					}",
			
            ))?>;
    return false; 
}

function updateAnalysis(referralId, id)
{
	<?php 
	echo CHtml::ajax(array(
			'url'=>$this->createUrl('analysis/update'),
			'data'=> "js:$(this).serialize()+ '&referralId='+referralId+ '&id='+id",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogAnalysis').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#dialogAnalysis form').submit(updateAnalysis);
                }
                else
                {
                    $.fn.yiiGridView.update('analysis-grid');
					$('#dialogAnalysis').html(data.div);
                    setTimeout(\"$('#dialogAnalysis').dialog('close') \",1000);
                }
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogAnalysis").html(
						\'<div class="loader">'.$image.'<br\><br\>Retrieving record.<br\> Please wait...</div>\'
					);
            }',
			 'error'=>"function(request, status, error){
				 	$('#dialogAnalysis').html(status+'('+error+')'+': '+ request.responseText+ ' {'+error.code+'}' );
					}",
            ))?>;
    return false; 
 
}

function searchAgency(id)
{
	<?php 
	echo CHtml::ajax(array(
			'url'=>$this->createUrl('referral/searchAgency'),
			'data'=> "js:$(this).serialize()+ '&id='+id",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
            	
            	$.fn.yiiGridView.update('agency-grid');
                /*if (data.status == 'failure')
                {
                    //$('#dialogSearchAgency').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    //$('#dialogSearchAgency form').submit(searchAgency);
                }
                else
                {
                    $.fn.yiiGridView.update('agency-grid');
                    //$.fn.yiiGridView.update('analysis-grid');
					//$('#dialogSearchAgency').html(data.div);
                    //setTimeout(\"$('#dialogSearchAgency').dialog('close') \",1000);
                }*/
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogSearchAgency").html(
						\'<div class="loader">'.$image.'<br\><br\>Retrieving record.<br\> Please wait...</div>\'
					);
            }',
			 'error'=>"function(request, status, error){
				 	$('#dialogSearchAgency').html(status+'('+error+')'+': '+ request.responseText+ ' {'+error.code+'}' );
					}",
            ))?>;
    return false; 
}

function sendReferral(agency_id, agencyName, referral_id, referralCode)
{
	<?php 
	echo CHtml::ajax(array(
			'url'=>$this->createUrl('referralstatus/create'),
			'data'=> "js:$(this).serialize()+ '&agency_id='+agency_id+ '&agencyName='+agencyName+ '&referral_id='+referral_id+ '&referralCode='+referralCode",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogSendReferral').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#dialogSendReferral form').submit(sendReferral);
                }
                else
                {
					$('#dialogSendReferral').html(data.div);
                    setTimeout(\"$('#dialogSendReferral').dialog('close') \",1000);
                    location.reload();
                }
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogSendReferral").html(
						\'<div class="loader">'.$image.'<br\><br\>Retrieving record.<br\> Please wait...</div>\'
					);
            }',
			 'error'=>"function(request, status, error){
				 	$('#dialogSendReferral').html(status+'('+error+')'+': '+ request.responseText+ ' {'+error.code+'}' );
					}",
            ))?>;
    return false; 
}

function sendReferral2(agency_id, agencyName, referral_id, referralCode)
{
	<?php 
	echo CHtml::ajax(array(
			'url'=>$this->createUrl('referral/send'),
			'data'=> "js:$(this).serialize()+ '&agency_id='+agency_id+ '&agencyName='+agencyName+ '&referral_id='+referral_id+ '&referralCode='+referralCode",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogSendReferral').html(data.div);
                    // Here is the trick: on submit-> once again this function!
                    $('#dialogSendReferral form').submit(sendReferral);
                }
                else
                {
					$('#dialogSendReferral').html(data.div);
                    setTimeout(\"$('#dialogSendReferral').dialog('close') \",1000);
                    location.reload();
                }
            }",
			'beforeSend'=>'function(jqXHR, settings){
                    $("#dialogSendReferral").html(
						\'<div class="loader">'.$image.'<br\><br\>Retrieving record.<br\> Please wait...</div>\'
					);
            }',
			 'error'=>"function(request, status, error){
				 	$('#dialogSendReferral').html(status+'('+error+')'+': '+ request.responseText+ ' {'+error.code+'}' );
					}",
            ))?>;
    return false; 
}
</script>