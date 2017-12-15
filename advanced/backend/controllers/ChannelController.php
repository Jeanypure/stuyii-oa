<?php

namespace backend\controllers;

use backend\models\OaGoodsinfo;
use backend\unitools\PHPExcelTools;
use Yii;
use backend\models\Channel;
use backend\models\OaTemplatesVar;
use backend\models\OaTemplates;
use backend\models\ChannelSearch;
use backend\models\WishSuffixDictionary;
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
                'extra_images' => $extra_images,
                'sku' => $sku[0],

            ]);
        }
    }


    /*
     * 多属性信息
     */
    public function actionVariations($id){
        $dataProvider = new ActiveDataProvider([
            'query' => Wishgoodssku::find()->where(['pid'=>$id]),
            'pagination' => [
                'pageSize' => 200,

            ],
        ]);
        return $this->renderAjax('variations',[
            'dataProvider' => $dataProvider,

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
        $templates = OaTemplates::find()->where(['infoid' =>$id])->one();
        if(Yii::$app->request->isPost){

        }
        else{
            $inShippingService = $this->getShippingService('In');
            $OutShippingService = $this->getShippingService('Out');
            return $this->render('update',[
                'templates' =>$templates,
                'infoId' => $id,
                'inShippingService' => $inShippingService,
                'outShippingService' => $OutShippingService,

            ]);
        }

    }

    /**
     *
     *
     * ebay基本信息保存
     * @param $id
     */

    public function  actionEbaySave($id){
        $template = OaTemplates::find()->where(['nid'=>$id])->one();

        $data = $_POST['OaTemplates'];
        //设置默认物流
        try {
            $data['OutshippingMethod1']  or $data['OutshippingMethod1']=23;
            $data['InshippingMethod1'] = $data['InshippingMethod1']?:93;
            $template->setAttributes($data,true);
            if($template->update(true)){
                echo "保存成功";
            }
            else {
                echo "保存失败";
            }
        }
        catch (\Exception $ex){
            echo $ex;
        }

    }

    /**
     * ebay 完善模板
     * @param $id
     * @param $infoId
     */

    public function  actionEbayComplete($id, $infoId){
        $template = OaTemplates::find()->where(['nid'=>$id])->one();
        $info = OaGoodsinfo::find()->where(['pid'=>$infoId])->one();
        $data = $_POST['OaTemplates'];
        //设置默认物流
        try {
            $template->setAttributes($data,true);

            //动态计算产品的状态
            $complete_status = '';
            if (!empty($info->completeStatus)) {
                $status = str_replace('|eBay已完善', '', $info->completeStatus);
                $complete_status = $status . '|eBay已完善';
            }
            $info->completeStatus = $complete_status;
            if($template->update(true) && $info->save(false)){
                echo "保存成功";
            }
            else {
                echo "2保存失败";
            }
        }
        catch (\Exception $ex){
            echo "1保存失败";
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
        echo "保存成功！";
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
     * @brief ebay模板导出时多余的字段维护在一个数组中
     */
    private $extra_fields = ['nameCode','specifics'];//因其他需要返回的字段
    /**
     * @brief 导出ebay模板
     * @param $id
     */
    public  function  actionExportEbay($id)
    {
        $sql = "oa_P_ebayTemplates {$id}";
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
        $firstRow = $ret[0];
        //过滤掉多余字段
        $tabFields = array_filter(array_keys($firstRow),function($item){return !in_array($item,$this->extra_fields);});
        // 设置变体
        $checkSql = "select count(*) from oa_templates as ots left join 
                oa_templatesvar as otr on ots.nid=otr.tid where otr.tid={$id}";
        $flag = $db->createCommand($checkSql)->queryAll();
        if($flag<=1){
            $var =[];
        }
        else {
            $findSql = "select *,otr.sku as varSku,otr.quantity as varQuantity from oa_templates as ots left join 
                    oa_templatesvar as otr on ots.nid=otr.tid where otr.tid={$id}";
            $allRows = $db->createCommand($findSql)->queryAll();
            $picKey = json_decode($allRows[0]['property'],true)['pictureKey'];
            $columns = json_decode($allRows[0]['property'],true)['columns'];
            $extraPage = json_decode($allRows[0]['extraPage'],true)['images'];
            $picCount = count($extraPage);

            //设置属性名
            $variationSpecificsSet = ['NameValueList' =>[]];
            foreach ($columns as $col){
                $map = ['name'=>array_keys($col)[0],'value' =>array_values($col)[0]];
                array_push($variationSpecificsSet['NameValueList'],$map);
            }


        }

        // 写入列名
        foreach($tabFields as $num => $name){
            $objPHPExcel->getActiveSheet()->setCellValue(PHPExcelTools::stringFromColumnIndex($num).'1',$name);
        }

        //写入单元格值
        foreach ($ret as $rowNum => $row) {
            $row['Variation'] = json_encode($this->getVariations($allRows,$picKey,$picCount,$row['nameCode']));
            //specifics 重新赋值
            $specifics = json_decode($row['specifics'],true)['specifics'];
            foreach ($specifics as $index=>$map){
                $key = array_keys($map)[0];
                $value = array_values($map)[0];
                $row['Specifics'.strval($index+1)] = $key.':'.$value;
            }
            foreach($tabFields as $num => $name){
                $objPHPExcel->getActiveSheet()->setCellValue(PHPExcelTools::stringFromColumnIndex($num).($rowNum + 2),$row[$name]);
            }
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    /**
     * @brief 封装多属性的内部方法
     * @param $allRows,
     * @param $picKey,
     * @param $picCount
     * @param $accountName
     * @return array $var
     */
    private  function  getVariations($allRows,$picKey,$picCount,$accountName)
    {
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
                'SKU'=>$row['varSku'].'@#'.$accountName,
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
        return $var;
    }
    //导出数据 wish平台
    public  function actionExport($id){

        $objPHPExcel = new \PHPExcel();
        $sheet=0;
        $objPHPExcel->setActiveSheetIndex($sheet);
        $foos[0] = OaWishgoods::find()->where(['infoid'=>$id])->all();
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

//        $suffix = $this->actionFetchSuffix();
        $suffix = $this->actionSuffix();

//判断 @# 是否需要添加 规则：新账号需要拼接 @#

        foreach($suffix as $key=>$value){
            $sub1 = substr(substr($value,5),0,1);
            if($sub1=='E'){      //新账号
                $su = $this->sub_zhanghao($value,'_','-');
                $sub = '@#'.$su;

            }
            else{
                $sub = '';
            }


            $strvariant = $this->actionVariationWish($id,$sub);


            $row = $key+2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foos[0][0]['SKU'].$sub);
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
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,'');
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
     * 处理多属性
     * @param $id int 商品ID
     */
    function actionVariationWish($id,$sub){

        $variants = Wishgoodssku::find()->where(['pid'=>$id])->all();
        $variation = [];
        $varitem = [];
        if(!isset($variants)||empty($variants)){
            return;
        }

        foreach($variants as $key=>$value){
            $varitem['sku'] = $value['sku'].$sub;
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
        return $strvariant;
    }

    //截取wish_E100-swordyee  中间的 E100
    public function sub_zhanghao($selleruserid,$mark1,$mark2){

        $st =stripos($selleruserid,$mark1);
        $ed =stripos($selleruserid,$mark2);
        if(($st==false||$ed==false)||$st>=$ed)
            return 0;
        $kw=substr($selleruserid,($st+1),($ed-$st-1));
        return $kw;

    }


    /*
     *拼接 wish账号
     *
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
     * 处理wish账号,默认是表中所有的账号
     */

    public function actionSuffix(){

        $suffixAll = WishSuffixDictionary::find()
                ->asArray()
                ->all(); //返回数组对象
        $suffix = array_column($suffixAll, 'IbaySuffix');
        return $suffix;
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

    /**
     * 导出CSV文件
     * @param array $data        数据
     * @param array $header_data 首行数据
     * @param string $file_name  文件名称
     * @return string
     */
    public function actionExportCsv($data = [], $header_data = [], $file_name = '')
    {

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file_name.'.csv');
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');
        if (!empty($header_data)) {
            foreach ($header_data as $key => $value) {
                $header_data[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $header_data);
        }
        $num = 0;
        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;
        //逐行取出数据，不浪费内存
        $count = count($data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $num++;
                //刷新一下输出buffer，防止由于数据过多造成问题
                if ($limit == $num) {
                    ob_flush();
                    flush();
                    $num = 0;
                }
                $row = $data[$i];
                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8', 'gbk', $value);
                }
                fputcsv($fp, $row);
            }
        }
        fclose($fp);
    }

    /*
     * 导出Joom
     * @param int $id 商品id
     *
     */

    public function actionExportJoom($id){
        $sql = 'P_oa_toJoom @pid='.$id;
        $db = yii::$app->db;
        $query = $db->createCommand($sql);
        $joomRes = $query->queryAll();
        if(empty($joomRes)){
            return;
        }
        $data = $joomRes;
        $header_data = array_keys($joomRes[0]);
        $file_name = $joomRes[0]['Parent Unique ID'].'Joom-CSV';
        $this->actionExportCsv($data,$header_data,$file_name);

    }
}
