<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required', 'message' => 'Це поле повинно бути заповненим.'],
            // email has to be a valid email address
            ['email', 'email', 'message' => '«Email» є некоректним адресом.'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha','captchaAction' => 'catalog/captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Код',
            'name' => 'Имя',
            'email' => 'E-mail',
            'subject' => 'Тема повідомлення',
            'body' => 'Повідомлення',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            $data = ['Имя'=>$this->name, 'Email'=>$this->email, 'Сообщение'=>$this->body];
            Yii::$app->mailer->compose('message', ['data' => $data])
                ->setTo('info.catalog.ua@gmail.com')
                ->setFrom([$this->email => 'New message'])
                ->setSubject($this->subject)
                //->setTextBody($this->body)
                //->setHtmlBody('<b>Имя:</b> '.$this->name.'<br><b>Email:</b> '.$this->email.'<br><b>Тест:</b> '.$this->body)
                ->send();

            return true;
        }
        return false;
    }
}
