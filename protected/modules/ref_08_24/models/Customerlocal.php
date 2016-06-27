<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property string $customerName
 * @property string $agencyHead
 * @property integer $region_id
 * @property integer $province_id
 * @property integer $municipalityCity_id
 * @property integer $barangay_id
 * @property string $houseNumber
 * @property string $tel
 * @property string $fax
 * @property string $email
 * @property integer $type_id
 * @property integer $nature_id
 * @property integer $industry_id
 * @property string $create_time
 * @property string $update_time
 */
class Customerlocal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ulimslab.customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customerName, head, tel, fax, email, typeId, natureId, industryId, municipalitycity_id', 'required'),
			array('typeId, natureId, industryId, municipalitycity_id, barangay_id', 'numerical', 'integerOnly'=>true),
			array('customerName, address', 'length', 'max'=>200),
			array('head', 'length', 'max'=>100),
			array('tel, fax, email', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customerName, head, address, region_id, province_id, municipalitycity_id, barangay_id, completeAddress, tel, fax, email, typeId, natureId, industryId, created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customerName' => 'Agency / Customer',
			'head' => 'Head of Agency',
			'region_id' => 'Region',
			'province_id' => 'Province',
			'municipalitycity_id' => 'Municipality / City',
			'barangay_id' => 'Barangay',
			'address' => 'House No. / Rm. No. / Bldg. Name / Street Name',
			'tel' => 'Tel',
			'fax' => 'Fax',
			'email' => 'Email',
			'typeId' => 'Type',
			'natureId' => 'Nature of Business',
			'industryId' => 'Industry',
			'created' => 'Created',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('t.rstl_id', Yii::app()->getModule('user')->user()->profile->getAttribute('pstc'));
		$criteria->compare('customerName',$this->customerName,true);
		$criteria->compare('head',$this->head,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('typeId',$this->typeId);
		$criteria->compare('natureId',$this->natureId);
		$criteria->compare('industryId',$this->industryId);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->ulimsDb;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function listData()
	{
		return CHtml::listData(Customerlocal::model()->findAll(
			//'condition'=>'active = :active',
			//'order'=>'id ASC', 
			//'params'=>array(':active'=>1))
		
		),	'id', 'customerName');
	}
}
