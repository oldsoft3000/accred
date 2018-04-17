<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Particip;

/**
 * participSearch represents the model behind the search form of `app\models\particip`.
 */
class ParticipSearch extends Particip
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'gender', 'citizenship', 'passport_series', 'passport_number'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'date_of_birth', 'organization', 'registration_address', 'phone_number', 'visa_required', 'visa_passport_validity', 'visa_country', 'visa_city'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Particip::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'title' => $this->title,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'citizenship' => $this->citizenship,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'registration_address', $this->registration_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'visa_required', $this->visa_required])
            ->andFilterWhere(['like', 'visa_passport_validity', $this->visa_passport_validity])
            ->andFilterWhere(['like', 'visa_country', $this->visa_country])
            ->andFilterWhere(['like', 'visa_city', $this->visa_city]);

        return $dataProvider;
    }

    public function searchAll() {
        $query = Particip::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        if ( !\Yii::$app->user->can('admin') ) {
            $query->andFilterWhere([
                'created_by' => Yii::$app->user->id,
            ]);
        }

        return $query->all();
    }

    public function searchHotelReservation() {


        $rows = Yii::$app->db->createCommand('
            SELECT  particip.id,
                    first_name,
                    middle_name,
                    last_name,
                    hotel_reservation.id as reservation_id,
                    room_category.name as category_name,
                    room_type.name as type_name 
            FROM `particip`
            LEFT JOIN hotel_reservation ON (hotel_reservation.id = particip.hotel_reservation_id)
            LEFT JOIN hotel_room ON (hotel_room.id = hotel_reservation.room_id)
            LEFT JOIN room_category ON (room_category.id=hotel_room.category_id)
            LEFT JOIN room_type ON (room_type.id=hotel_room.type_id)')
            ->queryAll(); 



        return $rows;
    }
}
