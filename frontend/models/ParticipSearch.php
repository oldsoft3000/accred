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
            [['id', 'title', 'gender', 'citizenship', 'passport_type', 'passport_number', 'status'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'email', 'date_of_birth', 'organization', 'designation', 'registered_address', 'phone_number', 'fax_number', 'visa_required', 'visa_passport_validity', 'visa_country', 'visa_city', 'dietary_preference'], 'safe'],
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
            'citizenship' => $this->citizenship,
            'passport_type' => $this->passport_type,
            'passport_number' => $this->passport_number,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'registered_address', $this->registered_address])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'fax_number', $this->fax_number])
            ->andFilterWhere(['like', 'visa_required', $this->visa_required])
            ->andFilterWhere(['like', 'visa_passport_validity', $this->visa_passport_validity])
            ->andFilterWhere(['like', 'visa_country', $this->visa_country])
            ->andFilterWhere(['like', 'visa_city', $this->visa_city])
            ->andFilterWhere(['like', 'dietary_preference', $this->dietary_preference]);

        return $dataProvider;
    }
}
