<?php

namespace backend\controllers;

use backend\unitools\PHPExcelTools;
use Yii;
use backend\models\Channel;

use backend\models\OaTemplatesVar;
use backend\models\OaTemplates;

use backend\models\ChannelSearch;
use backend\models\Goodssku;
use backend\models\OaWishgoods;
use backend\models\Wishgoodssku;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
/**
 * ChannelController implements the CRUD actions for Channel model.
 */
class ChannelController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Channel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Channel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Channel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Channel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**

     * Updates an existing Channel model.Default wish.

     * If update is successful, the browser will be redirected to the 'editwish' page.
     * @param integer $id.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionUpdate($id)
    {

        $sku = OaWishgoods::find()->where(['infoid'=>$id])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Wishgoodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);

        if (!$sku) {
            throw new NotFoundHttpException("The product was not found.");
        }

        if($sku[0]->load(Yii::$app->request->post())){
            $dataPost =  $_POST;
            $sku[0]['main_image'] =  $dataPost['main_image'];
            unset( $sku[0]['extra_images']);
            foreach($dataPost["extra_images"] as $key=>$value){
                $sku[0]['extra_images'] .= $value."\n";

            }

            $sku[0]['extra_images'] = rtrim($sku[0]['extra_images'], "\n");


            $sku[0]->update(false);
            echo '更新成功！';

        }else{

            $extra_images =  explode("\n", $sku[0]['extra_images']) ;

            return $this->render('editwish',[
                'dataProvider' => $dataProvider,
                'extra_images' => $extra_images,
                'sku' => $sku[0],

            ]);
        }
    }


    /*
     * 多属性信息
     */
    public function actionVarations($id){
        $sku = OaWishgoods::find()->where(['infoid'=>$id])->all();
        $dataProvider = new ActiveDataProvider([
            'query' => Wishgoodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderAjax('varations',[
            'dataProvider' => $dataProvider,
            'sku' => $sku[0],

        ]);

    }

    /**
     * Updates an existing Channel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateEbay($id=45)
    {
        $info = OaTemplates::find()->where(['infoid' =>$id])->one();
        $templatesVar = new ActiveDataProvider([
            'query' => OaTemplatesVar::find()->where(['tid' =>$id]),
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);
        if(Yii::$app->request->isPost){

        }
        else{
            $inShippingService = $this->getShippingService('In');
            $OutShippingService = $this->getShippingService('Out');
            return $this->render('update',[
                'info' =>$info,
                'templatesVar' => $templatesVar,
                'inShippingService' => $inShippingService,
                'outShippingService' => $OutShippingService,

            ]);
        }

    }

    /**
     * ebay基本信息保存
     * @param $id
     */

    public function  actionEbaySave($id=45){
        $template = OaTemplates::find()->where(['infoid'=>$id])->one();
        $data = $_POST['OaTemplates'];
        //设置默认物流
        $data['OutshippingMethod1']  or $data['OutshippingMethod1']=23;
        $data['InshippingMethod1'] = $data['InshippingMethod1']?:93;
        $template->setAttributes($data,true);
        if($template->update(false)){
            echo "保存成功";
        }
        else {
            echo "保存失败";
        }

    }
    /**
     * @brief 多属性保存
     * @param $id
     */
    public function actionVarSave($id)
    {
        $varData = $_POST['OaTemplatesVar'];
        $pictureKey = $_POST['picKey'];
        $var = new OaTemplatesVar();
        $fields = $var->attributeLabels();
        $row = [];
        foreach ($varData as $key=>$value)
        {
            $value['tid'] = $id;
            //动态生成property列的值
            $property = ['columns' => [],'pictureKey'=>$pictureKey];
            foreach ($value as $field=>$val)
            {

                if (in_array($field,array_keys($fields)))
                {
                    $row[$field] = $val;
                }
                else{
                    array_push($property['columns'],[$field=>$val]);
                }
            }
            $row['property'] = json_encode($property);
            if(strpos($key, 'New') ===false){
                //update
                $ret =$this->findVar($key);
                $ret->setAttributes($row,$safeOnly=false);
                $ret->save(false);
            }
            else{
                //create
                $model = new OaTemplatesVar();
                $model->setAttributes($row);
                if($model->save(false)){

                }
                else {
                    echo "Wrong!";
                }
            }

        }
        //根据varId的值，来决定更新还是创建

    }

    /**
     * 多属性设置页面
     * @param $id
     * @return mixed
     */

    public function actionTemplatesVar($id)
    {
        $templatesVar = new ActiveDataProvider([
            'query' => OaTemplatesVar::find()->where(['tid' =>$id]),
            'pagination' => [
                'pageSize' => 150,
            ],
        ]);
        $propertyVar = OaTemplatesVar::find()->where(['tid'=>$id])->all();
        $columns = [];
        foreach ($propertyVar as $row){
            $pro = json_decode($row->property,true);
            $columns['pictureKey'] = $pro['pictureKey'];
            $col = $pro['columns'];
            foreach ($col as $ele){
                foreach ($ele as $key=>$value){
                    if(array_key_exists($key,$columns)){
                        array_push($columns[$key],$value);
                    }
                    else{
                        $columns[$key] =[$value];
                    }
                }
            }
        }
        return $this->renderAjax('templatesVar',[
            'templatesVar' => $templatesVar,
            'tid' => $id,
            'propertyVar' => $propertyVar,
            'columns' => $columns,
        ]);
    }

    /**
     * delete row from templatesVar
     * @return mixed
     */

    public function actionDeleteVar(){
        $id = $_POST["id"];

        // 根据id的类型来执行不同的操作
        if(is_array($id)){
            foreach($id as $row){
                $this->findVar($row)->delete();
            }

        }
        else{
            $this->findVar($id)->delete();
        }
    }


    /**
     * Deletes an existing Channel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * exists or not
     * @param $id
     * @return mixed
     */
    protected function findVar($id)
    {
        $model = OaTemplatesVar::find()->where(['nid'=>$id])->one();
        if (!empty($model))
        {
            return $model;
        }
        else{
            return false;
        }
    }
    /**
     * Finds the Channel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Channel the loaded model
     * @throws /NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Channel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /**
     *  返回物流名称
     */
    protected function getShippingService($type)
    {
        $sql = "select id, shippingName from oa_shippingService where type='{$type}'";
        $connection = Yii::$app->db;
        $ret = $connection->createCommand($sql)->queryAll();
        $options = ArrayHelper::map($ret, 'id','shippingName');
        return $options;
    }

    /**
     * @brief 导出ebay模板
     * @param $id
     */
    public  function  actionExportEbay($id=45)
    {
        $sql = 'oa_P_ebayTemplates';
        $db = yii::$app->db;
        $query = $db->createCommand($sql);
        $ret = $query->queryAll();
        if(empty($ret)){
            return;
        }
        $objPHPExcel = new \PHPExcel();
        $sheetNumber= 0;
        $objPHPExcel->setActiveSheetIndex($sheetNumber);
        $sheetName = 'ebay模板';
        $objPHPExcel->getActiveSheet()->setTitle($sheetName);
        header('Content-Type: application/vnd.ms-excel');
        $fileName = "eBay模板-".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$fileName .' ');
        header('Cache-Control: max-age=0');
        //获取列名&设置image字段
        $tabFields = [];
        $image = '';

        $templates = OaTemplates::find()->where(['infoid'=>45])->one();
        $firstRow = $ret[0];
        $tabFields = array_keys($firstRow);
        $mainPage = $templates->mainPage;
        $image .= $mainPage."\r\n";
        $extraPage = json_decode($templates->extraPage,true)['images'];
        foreach ($extraPage as $ima){
            $image .= $ima."\r\n";
        }

        // 设置变体
        $checkSql = "select count(*) from oa_templates as ots left join 
                oa_templatesvar as otr on ots.nid=otr.tid where ots.infoid=45";
        $flag = $db->createCommand($checkSql)->queryAll();
        if($flag<=1){
            $var =[];
        }
        else {
            $findSql = "select *,otr.sku as varSku,otr.quantity as varQuantity from oa_templates as ots left join 
                    oa_templatesvar as otr on ots.nid=otr.tid where ots.infoid=45";
            $allRows = $db->createCommand($findSql)->queryAll();
            $picKey = json_decode($allRows[0]['property'],true)['pictureKey'];
            $columns = json_decode($allRows[0]['property'],true)['columns'];
            $picCount = count($extraPage);

            //设置属性名
            $variationSpecificsSet = ['NameValueList' =>[]];
            foreach ($columns as $col){
                $map = ['name'=>array_keys($col)[0],'value' =>array_values($col)[0]];
                array_push($variationSpecificsSet['NameValueList'],$map);
            }

            //设置图片&//设置变体
            $pictures = [];
            $variation = [];
            foreach ($allRows as $row){
                $variationSpecificsSet = ['NameValueList' =>[]];
                $columns = json_decode($row['property'],true)['columns'];
                $value = ['value'=>''];
                foreach ($columns as $col){
                    if(array_keys($col)[0] == $picKey){
                        $value['value'] = $col[$picKey];
                        break;
                    }
                }
                foreach ($columns as $col){
                    $map = ['name'=>array_keys($col)[0],'value' =>array_values($col)[0]];
                    array_push($variationSpecificsSet['NameValueList'],$map);
                }
                $pic = ['VariationSpecificPictureSet'=>['PictureURL'=>[$row['imageUrl']]],'Value'=>$value['value']];
                array_push($pictures,$pic);
                $var = [
                    'SKU'=>$row['varSku'],
                    'Quantity'=>$row['varQuantity'],
                    'StartPrice'=>$row['retailPrice'],
                    'VariationSpecifics'=>$variationSpecificsSet,

                ];
                array_push($variation,$var);
            }

            $var = [
                'assoc_pic_key'=>$picKey,
                'assoc_pic_count'=>$picCount,
                'Variation'=>$variation,
                'Pictures'=>$pictures,
                'VariationSpecificsSet'=>$variationSpecificsSet
            ];
        }




        // 写入列名
        foreach($tabFields as $num => $name){
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcelTools::stringFromColumnIndex($num).'1',$name);
        }

        //写入单元格值
        foreach ($ret as $rowNum => $row) {
            $row['PictureURL'] = $image;
            $row['Variation'] = json_encode($var);
            foreach($tabFields as $num => $name){
                $objPHPExcel->getActiveSheet()->setCellValue(PHPExcelTools::stringFromColumnIndex($num).($rowNum + 2),$row[$name]);
            }
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    //导出数据
    public  function actionExport($id){

        $objPHPExcel = new \PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $foos[0] = OaWishgoods::find()->where(['infoid'=>$id])->all();
        $variants = Wishgoodssku::find()->where(['pid'=>$id])->all();
        $variation = [];
        $varitem = [];
        if(!isset($variants)||empty($variants)){
            return;
        }

        foreach($variants as $key=>$value){
            $varitem['sku'] = $value['sku'];
            $varitem['color'] = $value['color'];
            $varitem['size'] = $value['size'];
            $varitem['inventory'] = $value['inventory'];
            $varitem['price'] = $value['price'];
            $varitem['shipping'] = $value['shipping'];
            $varitem['msrp'] = $value['msrp'];
            $varitem['shipping_time'] = $value['shipping_time'];
            $varitem['main_image'] = $value['linkurl'];
            $variation[] = $varitem;
        }

        $strvariant = json_encode($variation,true);
        $columnNum = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P'];
        $colName = [
            'sku','selleruserid','name','inventory','price','msrp','shipping','shipping_time','main_image','extra_images',
            'variants','landing_page_url','tags','description','brand','upc'];
       $combineArr =  array_combine($columnNum,$colName);
        $sub = 1;
        foreach ($columnNum as $key=>$value){
            $objPHPExcel->getActiveSheet()->getColumnDimension($value)->setWidth(20);
            $objPHPExcel->getActiveSheet()->getStyle( $value.$sub)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->setTitle($foos[0][0]['SKU'])
                ->setCellValue($value.$sub, $combineArr[$value]);
        }

        $suffix = $this->actionFetchSuffix();

        foreach($suffix as $key=>$value){
            $row = $key+2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foos[0][0]['SKU']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$value);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foos[0][0]['title']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foos[0][0]['inventory']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foos[0][0]['price']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foos[0][0]['msrp']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foos[0][0]['shipping']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,'7-21');
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foos[0][0]['main_image']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foos[0][0]['extra_images']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$strvariant);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,'landing_page_url');
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foos[0][0]['tags']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foos[0][0]['description']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,'');
            $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,'');
        }

        header('Content-Type: application/vnd.ms-excel');
        $filename = 'Wish模版'.$foos[0][0]['SKU'].date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    /*
     * 拼接 wish账号
     */
    public function actionFetchSuffix(){

       $suffix = Yii::$app->db->createCommand(" 
            SELECT  DictionaryName    from  B_Dictionary
            WHERE CategoryID=12 AND  DictionaryName LIKE '%WIS%' AND Used=0
            ORDER BY DictionaryName ")->queryAll();

        foreach ($suffix as $val){
            $len = strlen($val["DictionaryName"])-3;
            $wish_suffix[]  = 'wish_'.substr($val["DictionaryName"],3,$len);
        }

        return $wish_suffix;

    }

    /*
    *编辑完成状态
   */
    public function actionWishSign($id){
        $completeStatus = Channel::find()->where(['pid'=>$id])->all();
        $completeStatus[0]->completeStatus = 'Wish已完善';
        $completeStatus[0]->update(false);
        echo 'Wish已完善';

    }
}
