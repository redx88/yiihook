<?php

/**
 * This is the model class for table "barangay".
 *
 * The followings are the available columns in table 'barangay':
 * @property integer $id
 * @property integer $municipalityCityId
 * @property integer $district
 * @property string $name
 */
class Barangay extends CFormModel
{
	public $id, $municipalityCityId, $district, $name;
	/**
	 * @return string the associated database table name
	 */
	/*public function tableName()
	{
		return 'barangay';
	}*/

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('municipalityCityId, name', 'required'),
			array('municipalityCityId, district', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, municipalityCityId, district, name', 'safe', 'on'=>'search'),
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
			'municipalityCityId' => 'Municipality City',
			'district' => 'District',
			'name' => 'Name',
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
		$criteria->compare('municipalityCityId',$this->municipalityCityId);
		$criteria->compare('district',$this->district);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	/*public function getDbConnection()
	{
		return Yii::app()->referralDb;
	}*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Barangay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function listData()
	{
		return CHtml::listData(Barangay::model()->findAll(), 'id', 'name');
	}	
	
	public static function listDataByMunicipalityCity($id)
	{
		return CHtml::listData(Barangay::model()->findAll(
			array('condition'=>'municipalityCityId = :municipalityCityId',
					'order'=>'name',
					'params'=>array(':municipalityCityId'=>$id))), 'id', 'name');
	}
}
