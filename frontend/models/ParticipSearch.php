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

    public function searchHotel() {
        $str = '
            SELECT  particip.id,
                    first_name,
                    middle_name,
                    last_name,
                    hotel.id as hotel_id,
                    category_name,
                    type_name,
                    hotel_index 
            FROM particip
            LEFT JOIN hotel ON (hotel.id = particip.hotel_id)';

        if ( !\Yii::$app->user->can('admin') ) {
            $str = $str . 'WHERE particip.created_by = :id'; 
        }
        $command = Yii::$app->db->createCommand($str);
        $rows = $command->bindValue(':id', Yii::$app->user->id)->queryAll();

        return $rows;
    }

    public function searchFlight() {
        $str = '
            SELECT  particip.id,
                    first_name,
                    middle_name,
                    last_name,
                    flight.arrival_date,
                    flight.departure_date
            FROM particip
            LEFT JOIN flight ON (flight.id = particip.flight_id)';

        if ( !\Yii::$app->user->can('admin') ) {
            $str = $str . 'WHERE particip.created_by = :id'; 
        }
        $command = Yii::$app->db->createCommand($str);
        $rows = $command->bindValue(':id', Yii::$app->user->id)->queryAll();

        return $rows;
    }

    public function searchTicket() {
        $str = '
            SELECT  particip.id,
                    first_name,
                    middle_name,
                    last_name,
                    ticket.id as ticket_id
            FROM particip
            LEFT JOIN ticket ON (ticket.id = particip.ticket_id)';

        if ( !\Yii::$app->user->can('admin') ) {
            $str = $str . 'WHERE particip.created_by = :id'; 
        }
        $command = Yii::$app->db->createCommand($str);
        $rows = $command->bindValue(':id', Yii::$app->user->id)->queryAll();

        return $rows;
    }

    public function searchCar() {
        $str = '
            SELECT  particip.id,
                    particip.first_name,
                    particip.middle_name,
                    particip.last_name,
                    car.id as car_id
            FROM particip
            LEFT JOIN car ON (car.id = particip.car_id)';

        if ( !\Yii::$app->user->can('admin') ) {
            $str = $str . 'WHERE particip.created_by = :id'; 
        }
        $command = Yii::$app->db->createCommand($str);
        $rows = $command->bindValue(':id', Yii::$app->user->id)->queryAll();

        return $rows;
    }

            /*'id' => 'ID',
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

            'id' => 'ID',
            'arrival_date' => 'Дата заезда',
            'departure_date' => 'Дата выезда',
            'guests' => 'Количество гостей',
            'type_name' => 'Тип размещения',
            'category_name' => 'Категория номера',
            'hotel_index' => 'Отель',

            'id' => 'ID',
            'arrival_place' => 'Место прибытия',
            'arrival_date' => 'Дата прибытия',
            'arrival_flight_number' => 'Номер рейса / номер поезда',
            'arrival_terminal' => 'Терминал',
            'departure_place' => 'Место отправления',
            'departure_date' => 'Дата отправления',
            'departure_flight_number' => 'Номер рейса / номер поезда',
            'departure_terminal' => 'Терминал',

            'id' => 'ID',
            'ticket_type' => 'Тип транспорта',
            'departure_date' => 'Дата отправления',
            'flight_number' => 'Номер рейса',
            'from' => 'Откуда',
            'where' => 'Куда',
            'class' => 'Класс',
            'passport_number' => 'Номер загран паспорта',
            'passport_validity' => 'Годен до',
            'bonus_card' => 'Бонусная карта',
            'company_name' => 'Название авиакомпании',

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
            'place_of_birth' => 'Место рождения',*/

    public function searchFull() {
        $str = '
            SELECT  particip.id,
                    particip.title,
                    particip.first_name,
                    particip.last_name,
                    particip.middle_name,
                    particip.first_name_latin,
                    particip.last_name_latin,
                    particip.gender,
                    particip.photo,
                    particip.citizenship,
                    particip.passport_series,
                    particip.passport_number,
                    particip.date_of_birth,
                    particip.place_of_birth,
                    particip.registration_address,
                    particip.visa_required,
                    particip.visa_passport_validity,
                    particip.visa_country,
                    particip.visa_city,
                    particip.organization,
                    particip.position,
                    particip.organization_latin,
                    particip.position_latin,
                    particip.email,
                    particip.phone_number,
                    hotel.id as hotel_id,
                    hotel.arrival_date as hotel_arrival_date,
                    hotel.departure_date as hotel_departure_date,
                    hotel.guests,
                    hotel.type_name,
                    hotel.category_name,
                    hotel.hotel_index,
                    flight.id as flight_id,
                    flight.arrival_place,
                    flight.arrival_date as flight_arrival_date,
                    flight.arrival_time as flight_arrival_time,
                    flight.arrival_flight_number,
                    flight.arrival_terminal,
                    flight.departure_place,
                    flight.departure_date as flight_departure_date,
                    flight.departure_time as flight_departure_time,
                    flight.departure_flight_number,
                    flight.departure_terminal,
                    ticket.id as ticket_id,
                    ticket.ticket_type,
                    ticket.departure_date as ticket_departure_date,
                    ticket.flight_number,
                    ticket.from,
                    ticket.where,
                    ticket.class,
                    ticket.passport_number as ticket_passport_number,
                    ticket.passport_validity as ticket_passport_validity,
                    ticket.bonus_card,
                    ticket.company_name,
                    car.id as car_id,
                    car.country as car_country,
                    car.car_number,
                    car.car_brand,
                    car.is_particip,
                    car.first_name as car_first_name,
                    car.middle_name as car_middle_name,
                    car.last_name as car_last_name,
                    car.first_name_latin as car_first_name_latin,
                    car.last_name_latin as car_last_name_latin,
                    car.date_of_birth as car_date_of_birth,
                    car.passport_series as car_passport_series,
                    car.passport_number as car_passport_number,
                    car.place_of_birth as car_place_of_birth
            FROM particip
            LEFT JOIN hotel ON (hotel.id = particip.hotel_id)
            LEFT JOIN flight ON (flight.id = particip.flight_id)
            LEFT JOIN ticket ON (ticket.id = particip.ticket_id)
            LEFT JOIN car ON (car.id = particip.car_id)';

        if ( !\Yii::$app->user->can('admin') ) {
            $str = $str . 'WHERE particip.created_by = :id'; 
        }
        $command = Yii::$app->db->createCommand($str);
        $rows = $command->bindValue(':id', Yii::$app->user->id)->queryAll();

        return $rows;
    }
}
