<?php

return array(
	'db'=>array(
		'connectionString' => 'mysql:host=localhost;dbname=ulimsportal',
		'emulatePrepare' => true,
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'charset' => 'utf8',
		//'tablePrefix' => '',
	),
	
	'ulimsDb'=>array(
		'connectionString'=>'mysql:host=localhost;dbname=ulimslab',
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'class'=>'CDbConnection',
		'charset' => 'utf8',
		//'tablePrefix' => '',
	),
	
	'referralDb'=>array(
		'connectionString'=>'mysql:host=localhost;dbname=onelabdb',
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'class'=>'CDbConnection',
		'charset' => 'utf8',
		//'tablePrefix' => '',
	),
	
	'cashierDb'=>array(
		'connectionString'=>'mysql:host=localhost;dbname=ulimscashiering',
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'class'=>'CDbConnection',
		'charset' => 'utf8',
		//'tablePrefix' => '',
	),
	
	'accountingDb'=>array(
		'connectionString'=>'mysql:host=localhost;dbname=ulimsaccounting',
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'class'=>'CDbConnection',
		'charset' => 'utf8',
		//'tablePrefix' => '',
	),
	
	'phAddressDb'=>array(
		'connectionString'=>'mysql:host=localhost;dbname=phaddress2',
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'class'=>'CDbConnection',
		'charset' => 'utf8',
		//'tablePrefix' => '',
	),
	
	'information_schema'=>array(
		'connectionString'=>'mysql:host=localhost;dbname=information_schema',
		'username' => 'dost9ulims',
		'password' => 'D0579Ul1m5',
		'class'=>'CDbConnection',
		'charset' => 'utf8'
	)
);
