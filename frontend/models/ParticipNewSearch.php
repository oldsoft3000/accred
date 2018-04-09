<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ParticipNew;

/**
 * ParticipNewSearch represents the model behind the search form of `app\models\ParticipNew`.
 */
class ParticipNewSearch extends ParticipNew
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'gender', 'passport_series', 'passport_number'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'date_of_birth', 'citizenship', 'organization', 'registration_address', 'phone_number', 'visa_required', 'visa_passport_validity', 'visa_country', 'visa_city', 'place_of_birth', 'first_name_latin', 'last_name_latin', 'position', 'organization_latin', 'position_latin', 'photo'], 'safe'],
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
        $query = ParticipNew::find();

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
            'title' => $this->title,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'visa_passport_validity' => $this->visa_passport_validity,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'citizenship', $this->citizenship])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'registration_address', $this->registration_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'visa_required', $this->visa_required])
            ->andFilterWhere(['like', 'visa_country', $this->visa_country])
            ->andFilterWhere(['like', 'visa_city', $this->visa_city])
            ->andFilterWhere(['like', 'place_of_birth', $this->place_of_birth])
            ->andFilterWhere(['like', 'first_name_latin', $this->first_name_latin])
            ->andFilterWhere(['like', 'last_name_latin', $this->last_name_latin])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'organization_latin', $this->organization_latin])
            ->andFilterWhere(['like', 'position_latin', $this->position_latin])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
