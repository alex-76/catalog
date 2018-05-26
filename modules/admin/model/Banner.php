<?php

namespace app\modules\admin\model;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $banner_id
 * @property string $name_company
 * @property string $date_begin
 * @property string $date_end
 * @property string $url
 * @property string $attributes
 * @property int $position
 * @property string $accsess
 */
class Banner extends \yii\db\ActiveRecord
{

    public $image;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_company', 'date_begin', 'date_end','accsess','position','url'], 'required'],
            [['date_begin', 'date_end'], 'safe'],
            [['accsess'], 'string'],
            [['name_company','attributes'], 'string', 'max' => 250],
            [['position'], 'string', 'max' => 4],
            [['image'], 'file', 'extensions' => 'png, jpg, gif','maxSize' => 1000000, 'tooBig' => 'Макс. розмір 1Mb'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'banner_id' => 'ID',
            'name_company' => 'Назва компанії',
            'date_begin' => 'Дата початку показу',
            'date_end' => 'Дата кінця показу',
            'url' => 'Адрес банера',
            'attributes' => 'Перелік атрибутів силки',
            'position' => 'Позиція',
            'accsess' => 'Статус',
            'image' => 'Прикріпити банер:',
        ];
    }

    /**
     * @return bool
     */
    public function upload() {
        if($this->validate()) {
            $path = 'images/store/' .$this->image->baseName.'.'.$this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true, $this->image->baseName);
            @unlink($path);
            return true;
        } else {
            return false;
        }
    }
}
