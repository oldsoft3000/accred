<?php

namespace app\models;

use Yii;
use common\helpers\Formater;
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
class Hotel extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['arrival_date', 'departure_date', 'guests', 'type_name', 'category_name', 'hotel_index'], 'required'],
            [['guests'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'arrival_date' => 'Дата заезда',
            'departure_date' => 'Дата выезда',
            'guests' => 'Количество гостей',
            'type_name' => 'Тип размещения',
            'category_name' => 'Категория номера',
            'hotel_index' => 'Отель',
        ];
    }

    public function beforeValidate() {
        $this->arrival_date = Formater::convertInput($this->arrival_date);
        $this->departure_date = Formater::convertInput($this->departure_date);
        return parent::beforeValidate();
    }

}
