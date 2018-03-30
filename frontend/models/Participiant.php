<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participiant".
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
 * @property int $passport_type
 * @property int $passport_number
 * @property string $organization
 * @property string $designation
 * @property string $registered_address
 * @property int $status
 * @property string $phone_number
 * @property string $fax_number
 * @property int $visa_required
 * @property string $visa_passport_validity
 * @property string $visa_country
 * @property string $visa_city
 * @property string $dietary_preference
 */
class Participiant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'participiant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'first_name', 'middle_name', 'last_name', 'gender', 'email', 'date_of_birth', 'citizenship', 'passport_type', 'passport_number', 'organization', 'designation', 'registered_address', 'status', 'phone_number', 'fax_number', 'visa_passport_validity', 'visa_country', 'visa_city', 'dietary_preference'], 'required'],
            [['id', 'title', 'gender', 'citizenship', 'passport_type', 'passport_number', 'status'], 'integer'],
            [['date_of_birth'], 'safe'],
            [['first_name', 'middle_name', 'last_name', 'email', 'organization', 'designation', 'registered_address', 'phone_number', 'fax_number', 'visa_passport_validity', 'visa_country', 'visa_city', 'dietary_preference'], 'string', 'max' => 100],
            [['visa_required'], 'string', 'max' => 1],
            [['id'], 'unique'],
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
            'passport_type' => 'Passport Type',
            'passport_number' => 'Passport Number',
            'organization' => 'Organization',
            'designation' => 'Designation',
            'registered_address' => 'Registered Address',
            'status' => 'Status',
            'phone_number' => 'Phone Number',
            'fax_number' => 'Fax Number',
            'visa_required' => 'Visa Required',
            'visa_passport_validity' => 'Visa Passport Validity',
            'visa_country' => 'Visa Country',
            'visa_city' => 'Visa City',
            'dietary_preference' => 'Dietary Preference',
        ];
    }
}
