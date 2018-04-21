<?php

namespace app\models;

use Yii;
use common\helpers\Formater;

/**
 * This is the model class for table "car".
 *
 * @property int $id
 * @property string $country
 * @property string $car_number
 * @property string $car_brand
 * @property int $is_particip
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $first_name_latin
 * @property string $last_name_latin
 * @property string $date_of_birth
 * @property int $passport_series
 * @property int $passport_number
 * @property string $place_of_birth
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country', 'car_number', 'car_brand'], 'required'],
            [['first_name',
            'middle_name',
            'last_name','first_name_latin','last_name_latin',
            'date_of_birth', 'passport_series', 'passport_number',
            'place_of_birth'], 'required', 'when' => function($model) {
                    return $model->is_particip == '2';
                }],
            [['is_particip', 'passport_series', 'passport_number'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['country', 'car_number', 'car_brand', 'first_name', 'middle_name', 'last_name', 'first_name_latin', 'last_name_latin', 'place_of_birth'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Страна регистрации автомобиля',
            'car_number' => 'Гос. номер автомобиля',
            'car_brand' => 'Марка автомобиля',
            'is_particip' => 'Участник',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'first_name_latin' => 'Имя (на латинице)',
            'last_name_latin' => 'Фамилия (на латинице)',
            'date_of_birth' => 'Дата рождения',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
            'place_of_birth' => 'Место рождения',
        ];
    }

    public function beforeValidate() {
        $this->date_of_birth = Formater::convertInput($this->date_of_birth);
        return parent::beforeValidate();
    }
}
