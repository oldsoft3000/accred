<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservation_hotel".
 *
 * @property int $id
 * @property string $arrival_date
 * @property string $departure_date
 * @property int $guests
 * @property int $type
 * @property int $category
 */
class ReservationHotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reservation_hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arrival_date', 'departure_date', 'guests', 'type', 'category'], 'required'],
            [['arrival_date', 'departure_date'], 'safe'],
            [['guests', 'type', 'category'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arrival_date' => 'Arrival Date',
            'departure_date' => 'Departure Date',
            'guests' => 'Guests',
            'type' => 'Type',
            'category' => 'Category',
        ];
    }
}
