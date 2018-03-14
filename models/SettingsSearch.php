<?php 

namespace settings\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use settings\models\Settings;

class SettingsSearch extends Settings
{

    public function rules()
    {
        return [
            [['key', 'name', 'value'], 'safe'],
            [['id','type'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Settings::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if($this->validate()){
            $query->andFilterWhere([
                'type' => $this->type,
            ]);

            $query->andFilterWhere(['id' => $this->id])
                ->andFilterWhere(['like', 'key', $this->key])
                ->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'value', $this->value]);
        }

        return $dataProvider;
    }

}
