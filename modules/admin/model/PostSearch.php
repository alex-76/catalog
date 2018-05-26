<?php

namespace app\modules\admin\model;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\model\Post;

/**
 * PostSearch represents the model behind the search form of `app\modules\admin\model\Post`.
 */
class PostSearch extends Post
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id', 'region_id', 'area_id', 'subcategory_id'], 'integer'],
            [['name_company', 'name_client', 'email', 'phone', 'url_site', 'description', 'plan', 'date_publication', 'logo_name', 'meta_description', 'keywords', 'access'], 'safe'],
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
        $query = Post::find()->with('area', 'region', 'subcategory', 'category')->joinWith('payments');

                $f = !empty($params['filter'])?$params['filter']:null;

                switch ($f) {
                    case  'danger': // < 0
                        $query->where(['<', 'payments.enddate', Yii::$app->formatter->asDate(time(), 'php:Y-m-d h:i:s')]);
                        break;
                    case  'warning': // 0 - 14 days
                        $query->where(['>', 'payments.enddate', Yii::$app->formatter->asDate(time(), 'php:Y-m-d h:i:s')])->
                            andWhere(['<', 'payments.enddate', Yii::$app->formatter->asDate(time()+1209600, 'php:Y-m-d h:i:s')]);
                        break;
                    case  'success': // > 14 days
                        $query->where(['>', 'payments.enddate', Yii::$app->formatter->asDate(time()+1209600, 'php:Y-m-d h:i:s')]);
                        break;
                }


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
            'post_id' => $this->post_id,
            'category_id' => $this->category_id,
            'region_id' => $this->region_id,
            'area_id' => $this->area_id,
            'subcategory_id' => $this->subcategory_id,
            'date_publication' => $this->date_publication,
        ]);

        $query->andFilterWhere(['like', 'name_company', $this->name_company])
            ->andFilterWhere(['like', 'name_client', $this->name_client])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'url_site', $this->url_site])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'plan', $this->plan])
            ->andFilterWhere(['like', 'logo_name', $this->logo_name])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'access', $this->access]);

        return $dataProvider;
    }
}
