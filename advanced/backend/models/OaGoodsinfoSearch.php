<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OaGoodsinfo;

/**
 * OaGoodsinfoSearch represents the model behind the search form about `backend\models\OaGoodsinfo`.
 */
class OaGoodsinfoSearch extends OaGoodsinfo
{
    /**
     * @inheritdoc
     *
     */


    public $GoodsName; //<=====就是加在这里
    public $vendor1;
    public $vendor2;
    public $vendor3;

    public $origin1;
    public $origin2;
    public $origin3;
    public $hopeWeight;

    public function rules()
    {
        return [
            [['pid','IsLiquid', 'IsPowder', 'isMagnetism', 'IsCharged'], 'integer'],
            [['hopeWeight','picStatus','isVar','vendor1','vendor2','vendor3','developer','devDatetime','updateTime','achieveStatus','GoodsCode',
                'GoodsName','SupplierName', 'AliasCnName','AliasEnName','PackName','description','Season','StoreName','DictionaryName',
                'possessMan2','possessMan1'],'safe'],

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
     * @param array $condition
     *
     * @return ActiveDataProvider
     */
    public function search($params,$condition = [],$unit)
    {


        $query = OaGoodsinfo::find()->joinWith('oa_goods')->orderBy(['pid' => SORT_DESC])->where($condition);
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

        /*
         * 分模块判断
         *
         */
        if($unit == '产品推荐'){
            if($role[0]['item_name']=='部门主管'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='eBay销售'||$role[0]['item_name']=='SMT销售'||$role[0]['item_name']=='wish销售'){
                $query->andWhere(['in', 'introducer', $users]);
            }
        }elseif($unit == '正向开发'||$unit == '逆向开发'){
            if($role[0]['item_name']=='部门主管'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='eBay销售'||$role[0]['item_name']=='SMT销售'||$role[0]['item_name']=='wish销售'){
                $query->andWhere(['in', 'introducer', $users]);
            }elseif ($role[0]['item_name']=='产品开发'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='产品开发组长'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }
        }elseif($unit == '属性信息'){
            if($role[0]['item_name']=='部门主管'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='eBay销售'||$role[0]['item_name']=='SMT销售'||$role[0]['item_name']=='wish销售'){
                $query->andWhere(['in', 'introducer', $users]);
            }elseif ($role[0]['item_name']=='产品开发'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='产品开发组长'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }
        }elseif($unit == '图片信息'){
            if($role[0]['item_name']=='部门主管'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='eBay销售'||$role[0]['item_name']=='SMT销售'||$role[0]['item_name']=='wish销售'){
                $query->andWhere(['in', 'introducer', $users]);
            }elseif ($role[0]['item_name']=='产品开发'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif($role[0]['item_name']=='产品开发组长'){
                $query->andWhere(['in', 'oa_goods.developer', $users]);
            }elseif ($role[0]['item_name']=='美工'){
                $query->andWhere(['in', 'possessMan1', $users]);
            }
        }

        // add conditions that should always apply here


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['pageSize']) && $params['pageSize'] ? $params['pageSize'] : 6,
            ],
        ]);

        // 增加关联字段的排序

//        $dataProvider->setSort([
//            'attributes' => [
//                /* 其它字段不要动 */
//                /* 下面这段是加入的 */
//                /*=============*/
//                'oa_goods.developer' => [
//                    'asc' => ['oa_goods.developer' => SORT_ASC],
//                    'desc' => ['oa_goods.developer' => SORT_DESC],
//                    'label' => '供应商连接1'
//                ],
//                /*=============*/
//            ]
//        ]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pid' => $this->pid,

            'SupplierName' => $this->SupplierName,
            'PackName'=>$this->PackName,
            'description'=>$this->description,
            'StoreName'=>$this->StoreName,
            'Season'=>$this->Season,
            'IsLiquid' => $this->IsLiquid,
            'isMagnetism' => $this->isMagnetism,
            'IsCharged' => $this->IsCharged,
            'DictionaryName'=>$this->DictionaryName,
            'IsPowder' => $this->IsPowder,
            'convert(varchar(10),devDatetime,121)'=>$this->devDatetime,
            'convert(varchar(10),updateTime,121)'=>$this->updateTime,
            'isVar' => $this->isVar,



        ]);

        $query->andFilterWhere(['like', 'possessMan1', $this->possessMan1]);
        $query->andFilterWhere(['like', 'vendor3', $this->vendor3]);
        $query->andFilterWhere(['like', 'vendor2', $this->vendor2]);
        $query->andFilterWhere(['like', 'vendor1', $this->vendor1]);
        $query->andFilterWhere(['like', 'picStatus', $this->picStatus]);
        $query->andFilterWhere(['like', 'AliasEnName', $this->AliasEnName]);
        $query->andFilterWhere(['like', 'AliasCnName', $this->AliasCnName]);
        $query->andFilterWhere(['like', 'GoodsName', $this->GoodsName]);
        $query->andFilterWhere(['like', 'achieveStatus', $this->achieveStatus]);
        $query->andFilterWhere(['like', 'GoodsCode', $this->GoodsCode]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'AliasCnName', $this->AliasCnName]);
        $query->andFilterWhere(['like', 'vendor1', $this->vendor1]);
        $query->andFilterWhere(['like', 'oa_goods.developer', $this->developer]);

        return $dataProvider;
    }
}
