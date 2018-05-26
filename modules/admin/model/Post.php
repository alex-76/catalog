<?php

namespace app\modules\admin\model;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $post_id
 * @property string $name_company
 * @property string $name_client
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $url_site
 * @property string $description
 * @property int $category_id
 * @property int $region_id
 * @property int $area_id
 * @property int $subcategory_id
 * @property string $plan
 * @property string $date_publication
 * @property string $logo_name
 * @property string $meta_description
 * @property string $keywords
 * @property string $access
 */
class Post extends \yii\db\ActiveRecord
{


    public $image;
    public $gallery;


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
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_company', 'name_client', 'address','email', 'phone', 'description', 'category_id', 'region_id', 'area_id', 'subcategory_id', 'date_publication','access','plan','logo_name'], 'required'],
            [['description', 'plan', 'access'], 'string'],
            [['category_id', 'region_id', 'area_id', 'subcategory_id'], 'integer'],
            [['date_publication'], 'safe'],
            [['name_company', 'name_client', 'address', 'meta_description', 'keywords'], 'string', 'max' => 250],
            [['email', 'phone'], 'string', 'max' => 100],
            [['url_site', 'logo_name'], 'string', 'max' => 200],
            [['image'], 'file', 'extensions' => 'png, jpg, gif','maxSize' => 900000, 'tooBig' => 'Макс. розмір 900Kb'],
            [['gallery'], 'file', 'extensions' => 'png, jpg, gif, doc, docx, xlsx, xls pdf','maxFiles'=>3,'maxSize' => 1500000, 'tooBig' => 'Макс. розмір 1.5Mb'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'ID',
            'name_company' => 'Назва компанії',
            'name_client' => 'Імя клієнта',
            'address' => 'Адреса',
            'email' => 'Email',
            'phone' => 'Телефон',
            'url_site' => 'Сайт',
            'description' => 'Опис',
            'category_id' => 'Рубрика',
            'region_id' => 'Область',
            'area_id' => 'Район',
            'subcategory_id' => 'Підрубрика',
            'plan' => 'Тарифний план',
            'date_publication' => 'Дата початку публікації',
            'logo_name' => 'Title',
            'meta_description' => 'Meta Description',
            'keywords' => 'Keywords',
            'access' => 'Статус',
            'image' => 'Прикріпити логотип:',
            'gallery' => 'Прикріпити файли:',
        ];
    }


    /**
     * @return bool
     */
    public function upload($id) {
        if($this->validate()) {
            $path = 'images/store/' .$this->image->baseName.'.'.$this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true, $this->image->baseName);
            @unlink($path);
            $this->updateImages($id);
            return true;
        } else {
            return false;
        }
    }


    public function uploadGallery($id) {
        if($this->validate()) {
            foreach ($this->gallery as $file) {
                $path = 'images/store/' .$file->baseName.'.'.$file->extension;
                $file->saveAs($path);
                $this->attachImage($path,false,$file->baseName);
                @unlink($path);
            }
            $this->updateImages($id);
            return true;
        } else {
            return false;
        }
    }

    public  function updateImages($id) {
        Yii::$app->db->createCommand("UPDATE image SET isMain = NULL WHERE 	itemId = ".$id." AND isMain != 1")->execute();
    }





    public function getCategory()
    {
        return $this->hasOne(Category::className(),['category_id' => 'category_id']);

    }

    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::className(),['subcategory_id' => 'subcategory_id']);

    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(),['region_id' => 'region_id']);

    }

    public function getArea()
    {
        return $this->hasOne(Area::className(),['area_id' => 'area_id']);

    }

    public function getPayments()
    {
        return $this->hasOne(Payments::className(),['post_id' => 'post_id']);

    }


}
