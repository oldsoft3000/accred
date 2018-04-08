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
            [['first_name', 'middle_name', 'last_name', 'email', 'date_of_birth', 'organization', 'registration_address', 'phone_number', 'visa_passport_validity', 'visa_country', 'visa_city', 'place_of_birth', 'first_name_latin', 'last_name_latin', 'position', 'organization_latin', 'position_latin', 'photo'], 'required'],
            [['date_of_birth', 'visa_passport_validity'], 'safe'],
            [['photo'], 'string'],
            [['first_name', 'middle_name', 'last_name', 'email', 'organization', 'registration_address', 'phone_number', 'visa_country', 'visa_city', 'place_of_birth', 'first_name_latin', 'last_name_latin', 'position', 'organization_latin', 'position_latin'], 'string', 'max' => 100],
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
            'title' => 'Title',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'email' => 'Email',
            'date_of_birth' => 'Date Of Birth',
            'citizenship' => 'Citizenship',
            'passport_series' => 'Passport Series',
            'passport_number' => 'Passport Number',
            'organization' => 'Organization',
            'registration_address' => 'Registration Address',
            'phone_number' => 'Phone Number',
            'visa_required' => 'Visa Required',
            'visa_passport_validity' => 'Visa Passport Validity',
            'visa_country' => 'Visa Country',
            'visa_city' => 'Visa City',
            'place_of_birth' => 'Place Of Birth',
            'first_name_latin' => 'First Name Latin',
            'last_name_latin' => 'Last Name Latin',
            'position' => 'Position',
            'organization_latin' => 'Organization Latin',
            'position_latin' => 'Position Latin',
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
