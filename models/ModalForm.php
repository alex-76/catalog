<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ModalForm extends Model
{
    public $name;
    public $email;
    public $tel;
    public $theme;
    public $text;
    public $flag;

    const SCENARIO_CAllBACK  = 'callback';
    const SCENARIO_WRITETOUS = 'writetous';



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'tel'], 'required','on' => self::SCENARIO_CAllBACK, 'message' => 'Це поле повинно бути заповненим.'],
            [['name', 'email'], 'required','on' => self::SCENARIO_WRITETOUS, 'message' => 'Це поле повинно бути заповненим.'],
            [['tel'], 'string','on' => self::SCENARIO_WRITETOUS],
            ['email', 'email', 'message' => 'Email повинен бути коректним.'],
            [['theme','text'], 'string','max' => 200],
            ['flag', 'integer'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name'  => 'Имя',
            'email' => 'E-mail',
            'tel'   => 'Телефон',
            'theme' => 'Вас цікавить',
            'text'  => 'Текст повідомлення',
        ];
    }

    // Order CallBack ---
    public function send($email,$thema)
    {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([(!empty($this->email))?$this->email:'info.catalog.ua@gmail.com' => 'Повідомлення'])
            ->setSubject($thema)
            ->setHtmlBody( '<b>Имя:</b> '.$this->name.'<br>
                            <b>Email:</b> '.$this->email.'<br>
                            <b>Телефон:</b> '.$this->tel.'<br>
                            <b>Вас цікавить:</b> '.$this->theme.'<br>
                            <b>Текст повідомлення:</b> '.$this->text)->send();

        return true;

    }


}
