<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaGoods;
/**
 * OaGoodsSearch represents the model behind the search form about `backend\models\OaGoods`.
 */
class OaGoodsSearch extends OaGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id'], 'integer'],
            [['img','cate', 'devNum', 'origin1', 'developer', 'introducer',
                'devStatus', 'checkStatus','subCate','vendor1','vendor2','vendor3',
                'origin2','origin3','introReason','approvalNote',
            ], 'string'],
            [['hopeRate','salePrice', 'hopeWeight','hopeMonthProfit','hopeSale','nid'], 'number'],
            [['cate','subCate','createDate', 'updateDate',], 'safe'],
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
    public function search($params,$devStatus,$checkStatus)
    {
        //返回当前登录用户
        $user = yii::$app->user->identity->username;

        // 返回当前用户管辖下的用户
        $sql = "oa_P_users '{$user}'";
        $connection = Yii::$app->db;
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        $users = [];
        foreach ($result as $user) {
            array_push($users, $user['userName']);
        }
        //产品审批状态
        if(!empty($checkStatus)){
            $query = OaGoods::find()->orderBy(['nid' => SORT_DESC])
                ->where(['checkStatus'=>$checkStatus])
                ->andWhere(['<>','checkStatus','已作废'])
                ->andWhere(['in', 'developer', $users])
            ;
        }
        //产品认领状态
        if(!empty($devStatus)){
            $query = OaGoods::find()->orderBy(['nid' => SORT_DESC])
                ->where(['devStatus'=>$devStatus])
                ->andWhere(['<>','checkStatus','已作废'])
                ->andWhere(['in', 'developer', $users])
            ;
        }

        //已认领产品从推荐消失
        //有推荐人，没作废的产品显示在产品推荐里面。
        if(empty($devStatus) && empty($checkStatus)){
            $query = OaGoods::find()->orderBy(['nid' => SORT_DESC])
                ->where(['<>','introducer',''])
                ->andWhere(['<>','checkStatus','已作废'])
                ->andWhere(['=','checkStatus','未认领'])
            ;
        }
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'nid' => $this->nid,
//            'hopeRate' => $this->hopeRate,
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
            'cate' => $this->cate,
            'subCate' => $this->subCate,
            'developer' => $this->developer,
            'introducer' => $this->introducer,
            'introReason' => $this->introReason,
            'checkStatus' => $this->checkStatus,
            'approvalNote' => $this->approvalNote,
        ]);
        $query->andFilterWhere(['like', 'cate', $this->cate])
            ->andFilterWhere(['like', 'subCate', $this->subCate])
            ->andFilterWhere(['like', 'devNum', $this->devNum])
            ->andFilterWhere(['like', 'origin1', $this->origin1])
            ->andFilterWhere(['like', 'developer', $this->developer])
            ->andFilterWhere(['like', 'introducer', $this->introducer])
            ->andFilterWhere(['like', 'introReason', $this->introReason])
            ->andFilterWhere(['like', 'approvalNote', $this->approvalNote])
            ->andFilterWhere(['like', 'checkStatus', $this->checkStatus]);
        return $dataProvider;
    }
}