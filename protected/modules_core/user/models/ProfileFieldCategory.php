<?php

/**
 * This is the model class for table "profile_field_category".
 *
 * The followings are the available columns in table 'profile_field_category':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $sort_order
 * @property integer $module_id
 * @property integer $visibility
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @package humhub.modules_core.user.models
 * @since 0.5
 */
class ProfileFieldCategory extends HActiveRecord {

    /**
     * Default Value for Sort Order
     *
     * @var Integer
     */
    public $sort_order = 100;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileFieldCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'profile_field_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, sort_order', 'required'),
            array('sort_order, module_id, visibility, created_by, updated_by', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, sort_order, module_id, visibility, created_at, created_by, updated_at, updated_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'fields' => array(self::HAS_MANY, 'ProfileField', 'profile_field_category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('base', 'ID'),
            'title' => Yii::t('base', 'Title'),
            'description' => Yii::t('base', 'Description'),
            'sort_order' => Yii::t('base', 'Sort order'),
            'module_id' => Yii::t('base', 'Module'),
            'visibility' => Yii::t('UserModule.base', 'Visibility'),
            'created_at' => Yii::t('base', 'Created at'),
            'created_by' => Yii::t('base', 'Created by'),
            'updated_at' => Yii::t('base', 'Updated at'),
            'updated_by' => Yii::t('base', 'Updated by'),
        );
    }

}