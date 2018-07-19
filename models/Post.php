<?php

namespace app\models;

use Yii;
use app\modules\admin\model\Payments;

//use app\components\Translit;

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
 * @property string $logo_name
 * @property string $date_publication
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
            ],
            //'class' => Translit::className()
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
            [['name_company', 'name_client', 'address','email', 'phone','region_id','category_id','subcategory_id','area_id','description'], 'required','message' => 'Це поле повинно бути заповненим.'],
            [['description', 'plan'], 'string'],
            [['category_id', 'region_id', 'area_id', 'subcategory_id'], 'integer'],
            [['name_company', 'name_client', 'address', 'meta_description', 'keywords'], 'string', 'max' => 250],
            [['email', 'phone'], 'string', 'max' => 100],
            ['email', 'email','message' => '«Email» є некоректним адресом.'],
            [['url_site', 'logo_name'], 'string', 'max' => 200],
            [['image'], 'file', 'extensions' => 'png, jpg, gif', 'maxSize' => 1000000, 'tooBig' => 'Макс. розмір 1Mb'],
            [['gallery'], 'file', 'extensions' => 'png, jpg, gif, doc, docx, xlsx, xls pdf','maxFiles'=>3,'maxSize' => 1500000, 'tooBig' => 'Макс. розмір 1.5Mb'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'name_company' => 'Назва компанії *',
            'name_client' => 'Контактна особа *',
            'address' => 'Адреса *',
            'email' => 'Email *',
            'phone' => 'Телефон *',
            'url_site' => 'Адреса сайта',
            'description' => 'Опис діяльності *',
            'category_id' => 'Обрати рубрику *',
            'region_id' => 'Обрати область *',
            'area_id' => 'Обрати район *',
            'subcategory_id' => 'Обрати підрубрику',
            'plan' => 'Виберіть тарифний план',
            'image' => 'Завантажити логотип',
            'gallery' => 'Завантажити файли',
            'date_publication'=>'Дата публікації',
            'meta_description' => 'Опис мета-тегів',
            'keywords' => 'Ключові слова',
            'access' => 'Статус публікації'
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




    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::className(),['subcategory_id' => 'subcategory_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['region_id' => 'region_id']);
    }
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['area_id' => 'area_id']);
    }
    public function getPayments()
    {
        return $this->hasOne(Payments::className(),['post_id' => 'post_id']);

    }


}
