<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $news_id
 * @property string $title_news
 * @property string $name_news
 * @property string $description
 * @property string $meta_keyword
 * @property string $meta_description
 * @property string $alt_image
 * @property string $title_image
 * @property string $access
 * @property string $date_news
 * @property string $author
 */
class News extends \yii\db\ActiveRecord
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
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_news', 'name_news', 'description', 'meta_keyword', 'meta_description', 'alt_image', 'title_image', 'access', 'date_news','author'], 'required'],
            [['description', 'access'], 'string'],
            [['date_news'], 'safe'],
            [['title_news', 'name_news', 'meta_keyword', 'meta_description', 'alt_image', 'title_image','author'], 'string', 'max' => 250],
            [['image'], 'file', 'extensions' => 'png, jpg, gif','maxSize' => 900000, 'tooBig' => 'Макс. розмір 900Kb'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'title_news' => 'Заголовок статті',
            'name_news' => 'Назва новин',
            'description' => 'Опис',
            'meta_keyword' => 'Meta Keyword',
            'meta_description' => 'Meta Description',
            'alt_image' => 'Alt головне фото',
            'title_image' => 'Title головне фото',
            'access' => 'Статус',
            'date_news' => 'Дата публікації',
            'author' => 'Автор',
            'image' => 'Прикріпити фото',
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



    public function getReviews()
    {
        return $this->hasMany(Reviews::className(),['news_id' => 'news_id']);
    }
}
