<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hotel;
use app\models\Particip;

/**
 * HotelSearch represents the model behind the search form of `app\models\Hotel`.
 */
class HotelSearch extends Hotel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description'], 'safe'],
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
        $query = Hotel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function searchAll() {
        $query = Particip::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        /*$query
            ->select(   'particip.id, 
                        first_name,
                        middle_name,
                        last_name,
                        reservation_hotel.id AS reservation_id,
                        room_category.name AS category_name,
                        room_type.name AS type_name' )
            ->leftJoin('reservation_hotel', '(reservation_hotel.id = particip.reservation_hotel)')
            ->leftJoin('room_category', '(room_category.id = reservation_hotel.category)')
            ->leftJoin('room_type', '(room_type.id = reservation_hotel.type)');*/

        $query
            ->select(   'particip.id, 
                        first_name,
                        middle_name,
                        last_name,
                        reservation_hotel.id AS reservation_id' )
            ->leftJoin('reservation_hotel', '(reservation_hotel.id = particip.reservation_hotel)')
            ->with('Hotel')->all();



        /*if ( !\Yii::$app->user->can('admin') ) {
            $query->andFilterWhere([
                'created_by' => Yii::$app->user->id,
            ]);
        }*/

        return $query->all();
    }

    // Список Номеров
    public static function getRoomsByHotel($hotel) {
        $rows = Yii::$app->db->createCommand('
            SELECT  *
            FROM `hotel_room`
            WHERE hotel_room.hotel_id=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();

        return $rows;
        
    }

    public static function getRoomCategoriesByHotel($hotel) {
        $rows = Yii::$app->db->createCommand('
            SELECT  DISTINCT room_category.id, room_category.name
            FROM `hotel_room`
            JOIN room_category ON room_category.id = hotel_room.category_id
            WHERE hotel_room.hotel_id=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();

        return $rows;
    }

    public static function getRoomTypesByHotel($hotel) {
        $rows = Yii::$app->db->createCommand('
            SELECT  DISTINCT room_type.id, room_type.name
            FROM `hotel_room`
            JOIN room_type ON room_type.id = hotel_room.type_id
            WHERE hotel_room.hotel_id=:id')
            ->bindValue(':id', $hotel)
            ->queryAll();

        return $rows;
    }

}

