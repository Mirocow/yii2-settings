<?php 

namespace settings\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use settings\models\Settings;

/**
 * Class SettingsSearch
 * @package settings\models
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string|array $value
 * @property string $group_name
 */
class SettingsSearch extends Settings
{

    public function rules()
    {
        return [
            [['key', 'name', 'value', 'group_name'], 'safe'],
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
                ->andFilterWhere(['like', 'value', $this->value])
                ->andFilterWhere(['like', 'group_name', $this->group_name]);
        }

        return $dataProvider;
    }

}
