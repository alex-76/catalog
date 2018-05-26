<?php

namespace app\modules\admin\model;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\model\Banner;

/**
 * BannerSearch represents the model behind the search form of `app\modules\admin\model\Banner`.
 */
class BannerSearch extends Banner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id'], 'integer'],
            [['name_company', 'date_begin', 'date_end', 'position', 'accsess'], 'safe'],
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
        $query = Banner::find()->orderBy('position DESC');

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
            'banner_id' => $this->banner_id,
            'date_begin' => $this->date_begin,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'name_company', $this->name_company])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'accsess', $this->accsess]);

        return $dataProvider;
    }
}
