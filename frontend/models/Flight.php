<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flight".
 *
 * @property int $id
 * @property string $arrival_place
 * @property string $arrival_date
 * @property string $arrival_time
 * @property string $arrival_flight_number
 * @property string $arrival_terminal
 * @property string $departure_place
 * @property string $departure_date
 * @property string $departurel_time
 * @property string $departurel_flight_number
 * @property string $departurel_terminal
 */
class Flight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'flight';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arrival_date', 'arrival_time', 'departure_date', 'departurel_time'], 'safe'],
            [['arrival_place', 'arrival_flight_number', 'arrival_terminal', 'departure_place', 'departurel_flight_number', 'departurel_terminal'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arrival_place' => 'Arrival Place',
            'arrival_date' => 'Arrival Date',
            'arrival_time' => 'Arrival Time',
            'arrival_flight_number' => 'Arrival Flight Number',
            'arrival_terminal' => 'Arrival Terminal',
            'departure_place' => 'Departure Place',
            'departure_date' => 'Departure Date',
            'departurel_time' => 'Departurel Time',
            'departurel_flight_number' => 'Departurel Flight Number',
            'departurel_terminal' => 'Departurel Terminal',
        ];
    }
}
