<?php
namespace app\models;

use app\models\User;
use yii\data\ActiveDataProvider;

class SearchUser extends User
{

    public $user_lavel;
    
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['phone', 'email'], 'safe'],
            [['user_lavel'], 'safe']
        ];
    }

    public function search($params)
    {
        $subQuery = User::find()
            ->select(['user.*', 'user_lavel.*'])
            ->leftJoin('user', 'user.id = user_lavel.user_id')
            ->with('user_lavel');
            //->groupBy('user.id');

        $query = User::find()->from($subQuery);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['user_lavel'] = [
            'asc' => ['user_lavel' => SORT_ASC],
            'desc' => ['user_lavel' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['user_lavel' => $this->user_lavel]);

         $query->andFilterWhere(['like', 'username', $this->username]);
        //     ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            // ->andFilterWhere(['like', 'surname', $this->surname]);

        return $dataProvider;
    }
}
?>