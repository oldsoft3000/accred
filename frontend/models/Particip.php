<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "particip".
 *
 * @property int $id
 * @property int $title
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property int $gender
 * @property string $email
 * @property string $date_of_birth
 * @property int $citizenship
 * @property int $passport_series
 * @property int $passport_number
 * @property string $organization
 * @property string $registration_address
 * @property string $phone_number
 * @property int $visa_required
 * @property string $visa_passport_validity
 * @property string $visa_country
 * @property string $visa_city
 * @property string $place_of_birth
 * @property string $first_name_latin
 * @property string $last_name_latin
 * @property string $position
 * @property string $organization_latin
 * @property string $position_latin
 * @property resource $photo
 */
class Particip extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'particip';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'gender', 'passport_series', 'passport_number', 'visa_required'], 'integer'],
            [['title', 'first_name', 'last_name', 'gender', 'email', 'date_of_birth',
            'registration_address', 'phone_number',
            'place_of_birth', 'first_name_latin', 'last_name_latin', 'position',
            'position_latin', 'citizenship', 'passport_series', 'passport_number'], 'required'],
            [['date_of_birth', 'visa_passport_validity'], 'date', 'format' => 'yyyy-MM-dd'],
            [['visa_passport_validity', 'visa_country', 'visa_city'], 'required', 'when' => function($model) {
                    return $model->visa_required == '1';
                }],
            [['photo'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'email', 'organization', 'registration_address',
            'phone_number', 'visa_country', 'visa_city', 'place_of_birth', 'first_name_latin',
            'last_name_latin', 'position', 'organization_latin', 'position_latin'], 'string', 'max' => 100],
            [['citizenship', 'visa_country'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Обращение',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'last_name' => 'Фамилия',
            'gender' => 'Пол',
            'email' => 'E-mail',
            'date_of_birth' => 'Дата рождения',
            'citizenship' => 'Гражданство',
            'passport_series' => 'Серия',
            'passport_number' => 'Номер',
            'organization' => 'Организация',
            'registration_address' => 'Адрес регистрации',
            'phone_number' => 'Телефон',
            'visa_required' => 'Требуется виза',
            'visa_passport_validity' => 'Срок действия паспорта',
            'visa_country' => 'Страна получения визы',
            'visa_city' => 'Город получения визы',
            'place_of_birth' => 'Место рождения',
            'first_name_latin' => 'Имя (на латинице)',
            'last_name_latin' => 'Фамилия (на латинице)',
            'position' => 'Должность',
            'organization_latin' => 'Организация (на латинице)',
            'position_latin' => 'Должность (на латинице)',
            'photo' => 'Photo',
        ];
    }

    public function beforeValidate() {

        $this->date_of_birth = Yii::$app->formatter->asDate($this->date_of_birth, 'yyyy-MM-dd');
        $this->visa_passport_validity = Yii::$app->formatter->asDate($this->visa_passport_validity, 'yyyy-MM-dd');

        return parent::beforeValidate();
    }

    public function afterFind() {
        //$this->date_of_birth = date('Y/m/d', strtotime($this->date_of_birth));
        //$this-> visa_passport_validity = date('Y/m/d', strtotime($this->visa_passport_validity));
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->created_by = Yii::$app->user->id;
            return true;
        }
        return false;
    }

}
