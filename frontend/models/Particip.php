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
class Particip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'particip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'gender', 'citizenship', 'passport_series', 'passport_number'], 'integer'],
            [['title','first_name', 'last_name', 'email', 'date_of_birth',
              'registration_address', 'phone_number', 'visa_passport_validity', 'visa_country', 'visa_city',
              'place_of_birth', 'first_name_latin', 'last_name_latin', 'position',
              'position_latin','citizenship','passport_series','passport_number'], 'required'],
            [['photo'], 'string'],
            ['phone_number','match','pattern'=>'\+[0-9]{1}([0-9]{3}\)[0-9]{3}\-[0-9]{2}\-[0-9]{2}', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
            [['first_name', 'middle_name', 'last_name', 'email', 'organization', 'registration_address',
                'phone_number', 'visa_country', 'visa_city', 'place_of_birth', 'first_name_latin',
                'last_name_latin','position', 'organization_latin', 'position_latin'], 'string', 'max' => 100],
            [['visa_required'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
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
    
    public function beforeValidate()
    {
        /*if ($this->isNewRecord)
        {
            $this->date_of_birth = Yii::$app->formatter->asDateTime($this->date_of_birth, 'yyyy-MM-dd HH:mm:ss');
        }*/
        return parent::beforeValidate();
    }
}
