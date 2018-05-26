<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $region_id
 * @property string $name_region
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_region'], 'required'],
            [['name_region'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'name_region' => 'Name Region',
        ];
    }

    public function getArea()
    {
        return $this->hasMany(Area::className(),['region_id' => 'region_id']);

    }
}
