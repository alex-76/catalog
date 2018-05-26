<?php

namespace app\modules\admin\model;

use Yii;

/**
 * This is the model class for table "payments".
 *
 * @property int $pay_id
 * @property string $enddate
 * @property int $post_id
 */
class Payments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enddate'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_id' => 'Pay ID',
            'enddate' => 'Дата закінчення публікації',
            'post_id' => 'Post ID',
        ];
    }
}
