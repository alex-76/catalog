<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $reviews_id
 * @property string $name_user
 * @property string $email
 * @property string $date_publication
 * @property string $content
 * @property int $news_id
 * @property string $access
 */
class Reviews extends \yii\db\ActiveRecord
{
    public $meta_keyword;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_user', 'email', 'content','access'], 'required','message' => 'Це поле повинно бути заповненим.'],
            [['reviews_id', 'news_id'], 'integer'],
            ['email', 'email','message' => '«Email» є некоректним адресом.'],
            [['date_publication','news_id'], 'safe'],
            [['content', 'access'], 'string'],
            [['name_user', 'email'], 'string', 'max' => 250],
            [['reviews_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reviews_id' => 'ID',
            'name_user' => 'Імя',
            'email' => 'Email',
            'date_publication' => 'Дата публікації',
            'content' => 'Відгук',
            'news_id' => 'ID новин',
            'access' => 'Статус',
        ];
    }
}
