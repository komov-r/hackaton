<?php

/**
 * This is the model class for table "lost".
 *
 * The followings are the available columns in table 'lost':
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $city_id
 * @property integer $coordinator_id
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Area[] $areas
 * @property Balloon[] $balloons
 * @property Crew[] $crews
 * @property City $city
 * @property Coordinator $coordinator
 * @property Radius[] $radiuses
 */
class Lost extends CActiveRecord
{
    private $oldPhoto = null;

    private $oldFlyer = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'lost';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, city_id', 'required'),
            array('status, city_id, coordinator_id', 'numerical', 'integerOnly' => true),
            array('name, flyer', 'length', 'max' => 200),
            array('photo, age', 'safe'),
            array('id, name, status, city_id, coordinator_id, photo, flyer, date_created', 'safe', 'on' => 'search'),

            array('photo', 'file', 'types'=>'jpg, gif, png, bmp', 'allowEmpty'=>true),
            array('flyer', 'file', 'types'=>'jpg, gif, png, bmp', 'allowEmpty'=>true),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'areas' => array(self::HAS_MANY, 'Area', 'lost_id'),
            'balloons' => array(self::HAS_MANY, 'Balloon', 'lost_id'),
            'crews' => array(self::HAS_MANY, 'Crew', 'lost_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'coordinator' => array(self::BELONGS_TO, 'Coordinator', 'coordinator_id'),
            'radiuses' => array(self::HAS_MANY, 'Radius', 'lost_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Номер',
            'name' => 'Имя',
            'status' => 'Статус',
            'city_id' => 'Город',
            'coordinator_id' => 'Координатор',
            'date_created' => 'Дата создания',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('coordinator_id', $this->coordinator_id);
        $criteria->compare('date_created', $this->date_created, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function beforeValidate()
    {
        parent::beforeValidate();
        $this->photo=CUploadedFile::getInstance($this,'photo');
        $this->flyer=CUploadedFile::getInstance($this,'flyer');

        return true;
    }

    public function afterFind() {
        parent::afterFind();
        $this->oldFlyer = $this->flyer;
        $this->oldPhoto = $this->photo;
    }


    public function beforeSave() {
        $photosDir = Yii::app()->params['photosDir'];
        if(is_object($this->photo)) {
            $photoName = time();
            $this->photo->saveAs($photosDir.$photoName.'.'.$this->photo->getExtensionName(), false);
            $this->photo = $photoName;

            if(!empty($this->oldPhoto)) {
                $delete = $photosDir.$this->oldPhoto.'.'.$this->oldPhoto->getExtensionName();
                if(file_exists($delete)) unlink($delete);
            }
        }
        if(empty($this->photo) && !empty($this->oldPhoto)) $this->photo = $this->oldPhoto;

        $flyerDir = Yii::app()->params['flyerDir'];
        if(is_object($this->flyer)) {
            $flyerName = time() + 1;
            $this->flyer->saveAs($flyerDir.$flyerName.'.'.$this->flyer->getExtensionName(), false);
            $this->flyer = $flyerName;

            if(!empty($this->oldPhoto)) {
                $delete = $flyerDir.$this->oldFlyer.'.'.$this->oldFlyer->getExtensionName();
                if(file_exists($delete)) unlink($delete);
            }
        }
        if(empty($this->flyer) && !empty($this->oldFlyer)) $this->flyer = $this->oldFlyer;

        return parent::beforeSave();
    }


    public function afterDelete() {
        $this->deleteFiles();
        return parent::afterDelete();
    }

    public function deleteFiles() {
        return unlink(Yii::app()->params['photosDir'].$this->photo.'.'.$this->photo->getExtensionName());
    }

}