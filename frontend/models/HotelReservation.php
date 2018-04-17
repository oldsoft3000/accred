<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hotel_reservation".
 *
 * @property int $id
 * @property string $arrival_date
 * @property string $departure_date
 * @property int $guests
 * @property int $room_id
 */
class HotelReservation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_reservation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arrival_date', 'departure_date', 'guests', 'room_id'], 'required'],
            [['arrival_date', 'departure_date'], 'safe'],
            [['guests', 'room_id'], 'integer'],
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
            'room_id' => 'Room ID',
        ];
    }
}
