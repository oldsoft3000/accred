<?php

namespace app\models;

use Yii;
use common\helpers\Formater;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int $ticket_type
 * @property string $departure_date
 * @property string $flight_number
 * @property string $from
 * @property string $where
 * @property string $class
 * @property string $passport_number
 * @property string $passport_validity
 * @property string $bonus_card
 * @property string $company_name
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['ticket_type', 'departure_date', 'flight_number', 'from', 'where', 'class', 'passport_number', 'passport_validity', 'bonus_card', 'company_name'], 'required'],*/
            [['ticket_type'], 'integer'],
            [['departure_date', 'passport_validity'], 'safe'],
            [['flight_number', 'from', 'where', 'class', 'passport_number', 'bonus_card', 'company_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_type' => 'Ticket Type',
            'departure_date' => 'Departure Date',
            'flight_number' => 'Flight Number',
            'from' => 'From',
            'where' => 'Where',
            'class' => 'Class',
            'passport_number' => 'Passport Number',
            'passport_validity' => 'Passport Validity',
            'bonus_card' => 'Bonus Card',
            'company_name' => 'Company Name',
        ];
    }

    public function beforeValidate() {
        $this->departure_date = Formater::convertInput($this->departure_date);
        $this->passport_validity = Formater::convertInput($this->passport_validity);
        return parent::beforeValidate();
    }
}
