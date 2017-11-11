 public function actionUpdate($id)
    {
        $updata = $_POST;
        $info = OaGoodsinfo::findOne($id);
        $conid = Yii::$app->db->createCommand("SELECT goodsid from  oa_Goodsinfo WHERE pid=$id")
            ->queryOne();

        $goodsItem = OaGoods::find()->select('oa_goods.*')->where(['nid'=>$conid])->all();

        if (!$info) {
            throw new NotFoundHttpException("The product was not found.");
        }

        if($info->load(Yii::$app->request->post())){
            $SupplerName = $updata['OaGoodsinfo']['SupplierName'];
            // 如果该查询没有结果则返回 false
            $Suppler = Yii::$app->db->createCommand("SELECT * from  B_Supplier WHERE SupplierName='$SupplerName'")
                ->queryOne();
            if(empty($Suppler)){
                $Recorder = yii::$app->user->identity->username;
                $InputDate = strftime('%F %T');

                Yii::$app->db->createCommand("insert into  B_Supplier (SupplierName,Recorder,InputDate,Used) 
                  VALUES ('$SupplerName','$Recorder','$InputDate',0)")->execute();
            }

            $SupplerID = Yii::$app->db->createCommand("SELECT NID from  B_Supplier WHERE SupplierName='$SupplerName'")
                ->queryOne();

            $info->SupplierID = $SupplerID['NID'];


            if (!empty($updata['DictionaryName'])){
                $info->DictionaryName = implode(',',$updata['DictionaryName']);
            }
            $info->updateTime = strftime('%F %T');

            $info->developer = $updata['OaGoodsinfo']['developer'];

            $info->Purchaser = $updata['OaGoodsinfo']['Purchaser'];
            $info->possessMan1 = $updata['OaGoodsinfo']['possessMan1'];
            $info->AttributeName = $updata['OaGoodsinfo']['AttributeName'];
            if(empty($updata['OaGoodsinfo']['AttributeName'])){

            }
            $info->save(false);
            $sub_cate = $updata['OaGoods']['subCate'];
            try {
                $cateModel = GoodsCats::find()->where(['nid' => $sub_cate])->one();
            }
            catch (\Exception $e) {
                $cateModel = GoodsCats::find()->where(['CategoryName' => $sub_cate])->one();
            }
            $current_model = $goodsItem[0];
            $current_model->catNid = $cateModel->CategoryParentID;
            $current_model->cate = $cateModel->CategoryParentName;
            $current_model->subCate = $cateModel->CategoryName;
            $current_model->vendor1 = $updata['OaGoods']['vendor1'];
            $current_model->vendor2 = $updata['OaGoods']['vendor2'];
            $current_model->vendor3 = $updata['OaGoods']['vendor3'];
            $current_model->origin1 = $updata['OaGoods']['origin1'];
            $current_model->origin2 = $updata['OaGoods']['origin2'];
            $current_model->origin3= $updata['OaGoods']['origin3'];

            $current_model->developer= $updata['OaGoodsinfo']['developer'];
            $current_model->update(false);
            $this->redirect(['oa-goodsinfo/update','id'=>$id]);

        }else{

            $data = $this->actionSelectParam();
            $dataProvider = new ActiveDataProvider([
                'query' => Goodssku::find()->where(['pid'=>$id]),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]);

            return $this->render('updetail',[
                'info'=>$info,
                'pid' =>$id,
                'dataProvider' => $dataProvider,
                'result' => $data['res'],
                'lock' => $data['platFrom'],
                'packname' => $data['packname'],
                'goodsItem' => $goodsItem[0],

            ]);

        }



    }