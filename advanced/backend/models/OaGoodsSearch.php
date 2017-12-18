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
            [['hopeRate','salePrice', 'hopeWeight','hopeMonthProfit','hopeSale','hopeCost','nid'], 'number'],
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
    public function search($params,$devStatus,$checkStatus,$unit)
    {
        //返回当前登录用户
        $user = yii::$app->user->identity->username;

        //根据角色 过滤
        $role_sql = yii::$app->db->createCommand("SELECT t2.item_name FROM [user] t1,[auth_assignment] t2 
                    WHERE  t1.id=t2.user_id and
                    username='$user'
                    ");
        $role = $role_sql
            ->queryAll();

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

        /*
         * 分模块判断
         *
         */

        if($unit == '产品推荐'){
            if($role[0]['item_name']=='部门主管'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='eBay销售'||$role[0]['item_name']=='SMT销售'||$role[0]['item_name']=='Wish销售'){
                $query->andWhere(['in', 'introducer', $users]);

            }elseif($role[0]['item_name']=='产品开发组长'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }
        }elseif($unit == '正向开发'||$unit = '逆向开发'){
            if($role[0]['item_name']=='部门主管'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='eBay销售'||$role[0]['item_name']=='SMT销售'||$role[0]['item_name']=='Wish销售'){
                $query->andWhere(['in', 'introducer', $users]);
            }elseif ($role[0]['item_name']=='产品开发'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='产品开发组长'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }
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
            'createDate' => $this->createDate,
            'updateDate' => $this->updateDate,
//            'cate' => $this->cate,
//            'subCate' => $this->subCate,
//            'developer' => $this->developer,
//            'introducer' => $this->introducer,
//            'introReason' => $this->introReason,
//            'checkStatus' => $this->checkStatus,
//            'approvalNote' => $this->approvalNote,
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