<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "flight".
 *
 * @property int $id
 * @property string $arrival_place
 * @property string $arrival_date
 * @property string $arrival_flight_number
 * @property string $arrival_terminal
 * @property string $departure_place
 * @property string $departure_date
 * @property string $departure_flight_number
 * @property string $departure_terminal
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
            [['arrival_date', 'departure_date'], 'safe'],
            [[  'arrival_place',
                'arrival_date',
                'arrival_flight_number',
                'arrival_terminal',
                'departure_place',
                'departure_date',
                'departure_flight_number',
                'departure_terminal'], 'required'],
            [['arrival_place', 'arrival_flight_number', 'arrival_terminal', 'departure_place', 'departure_flight_number', 'departure_terminal'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arrival_place' => 'Место прибытия',
            'arrival_date' => 'Дата прибытия',
            'arrival_flight_number' => 'Номер рейса / номер поезда',
            'arrival_terminal' => 'Терминал',
            'departure_place' => 'Место отправления',
            'departure_date' => 'Дата отправления',
            'departure_flight_number' => 'Номер рейса / номер поезда',
            'departure_terminal' => 'Терминал',
        ];
    }
}
