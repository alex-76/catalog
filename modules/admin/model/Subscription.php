<?php

namespace app\modules\admin\model;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property int $sub_id
 * @property string $email
 * @property string $date
 */
class Subscription extends \yii\db\ActiveRecord
{
    public $emailFrom;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'date'], 'required'],
            ['email', 'email'],
            [['date'], 'safe'],
            [['email'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sub_id' => 'Sub ID',
            'email' => 'Email',
            'date' => 'Дата підписки',
        ];
    }

    // Check email
    public function checkEmail()
    {
        if ($this->validate()) {
            return true;
        }
        return false;
    }

    // Send email adress users ---
    public function send($email)
    {
        Yii::$app->mailer->compose('subscription')
            ->setTo($email)
            ->setFrom([$this->emailFrom => 'Новое сообщение'])
            ->setSubject('Рассылка клиентам')
            ->send();

        return true;

    }
}
