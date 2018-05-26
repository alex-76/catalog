<?php

namespace app\modules\admin\model;

use Yii;

/**
 * This is the model class for table "area".
 *
 * @property int $area_id
 * @property string $name
 * @property int $region_id
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'region_id'], 'required'],
            [['region_id'], 'integer'],
            [['name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'ID',
            'name' => 'Назва району',
            'region_id' => 'Область',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(),['region_id' => 'region_id']);

    }
}
