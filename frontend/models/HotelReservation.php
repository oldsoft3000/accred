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
 * @property int $type_id
 * @property int $category_id
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
            [['arrival_date', 'departure_date', 'guests', 'type_id', 'category_id'], 'required'],
            [['arrival_date', 'departure_date'], 'safe'],
            [['guests', 'type_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'arrival_date' => 'Дата заезда',
            'departure_date' => 'Дата выезда',
            'guests' => 'Количество гостей',
            'type_id' => 'Тип размещения',
            'category_id' => 'Категория номера',
        ];
    }
}
