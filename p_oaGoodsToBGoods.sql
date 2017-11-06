ALTER PROCEDURE [dbo].[P_OaGoodsToBGoods]
--oa表相应的信息导入到B 表中
--2017-11-02 james 动态的判断数据的更新或创建
-- 2017-11-03 James 自动生成申报价格
-- 2017-11-06 James
(
 @pid    INT
 )

AS
BEGIN

Set NOCOUNT ON;
Set XACT_ABORT ON;

DECLARE @MultiStyle int;
DECLARE @SkuTail varchar(5);
DECLARE @skuNumber int;
DECLARE @BgoodsNumber int;
DECLARE @SkuNumberDiff int;
DECLARE @OaSkuNumber int;
DECLARE @NewID INT;
DECLARE @minPrice DECIMAL(6,2); -- 最小零售价格
set @minPrice = (SELECT isnull(min(u.RetailPrice),0)  FROM  oa_goodssku u WHERE pid=@pid);

SET @OaSkuNumber = (select count(*) from oa_goodssku where pid=@pid);
SET @BgoodsNumber = (select count(*) from b_goods where nid in (select bgoodsid from oa_goodsinfo where pid =@pid)); -- 判断是否已存在
SET @skuNumber = (SELECT COUNT(*) FROM oa_goodssku WHERE pid=@pid);
SET @SkuNumberDiff = (select count(*) from  b_goodssku as bgsku LEFT JOIN oa_goodssku as ogsku on bgsku.nid= ogsku.goodsskuid LEFT JOIN oa_goodsinfo as ogs
on ogs.pid=ogsku.pid where ogs.pid=@pid and bgsku.nid is not null);

--SET @SKUParam = (SELECT GoodsCode FROM oa_goodsinfo WHERE pid =@pid);


IF @skuNumber>1
BEGIN
SET @MultiStyle = 1;
set @SkuTail = '';
END
ELSE
BEGIN
SET @MultiStyle = 0;
SET @SkuTail = '01';
END




	--Begin Tran toBgoods   --开始事务toBgoods
				--对接插入B_Goods

		Begin Tran toBgoods   --开始事务toBgoods
					if @BgoodsNumber = 0  -- 创建b_goods
					begin

						--对接插入B_Goods
						INSERT into B_Goods (
						GoodsCategoryID,
						CategoryCode,
						GoodsCode,
						GoodsName,
						SKU,										--单属性是SKU 多属性是商品编码
						MultiStyle,            --单属性是0 多属性是1
						salePrice,
					  CostPrice,
						AliasCnName,
						AliasEnName,
						Weight,
						--DeclaredValue,
						OriginCountry,
						OriginCountryCode,
						SupplierID,
						SalerName, 												--开发员
						PackName,
						GoodsStatus,
						DevDate,
						RetailPrice,
						StoreID,
						Purchaser,
						LinkUrl,
						LinkUrl2,
						LinkUrl3,
						IsCharged,
						Season,
						IsPowder,
						IsLiquid,
						possessMan1,
						LinkUrl4,
						LinkUrl5,
						LinkUrl6,
						isMagnetism,
						DeclaredValue
						)

				SELECT
				isnull(c.nid,'') as GoodsCategoryID,
			isnull(c.CategoryCode,''),
			isnull(o.GoodsCode,''),
			isnull(o.GoodsName,''),
		   isnull(o.GoodsCode,'') + @SkuTail as SKU,
      @MultiStyle as  MultiStyle,
			isnull(s.salePrice,0),
			 (SELECT isnull(MAX(u.CostPrice),0)  FROM  oa_goodssku u WHERE pid=@pid)as CostPrice , --取子SKU最高价
			isnull(o.AliasCnName,''),
			isnull(o.AliasEnName,''),
			(SELECT isnull(MAX(u.Weight),0)  FROM  oa_goodssku u WHERE pid=@pid) as Weight, -- 重量取SKU最大重量
			--isnull(o.DeclaredValue,''),
			'China' as OriginCountry,
			'CN' as OriginCountryCode,
			isnull(o.SupplierID,''),
			isnull(s.developer,'') as  SalerName,                 --开发员
			isnull(o.PackName,''),
			'在售' as GoodsStatus,
			isnull(s.createDate,'') as DevDate, --开发时间
			(SELECT isnull(MAX(u.RetailPrice),0)  FROM  oa_goodssku u WHERE pid=@pid) as RetailPrice,
			isnull(e.NID ,'') AS StoreID,
			isnull(o.Purchaser,'') ,
			isnull(s.vendor1,'') as LinkUrl,
			isnull(s.vendor2,'') as LinkUrl2,
			isnull(s.vendor3,'') as LinkUrl3,
			isnull(IsCharged,0),
			isnull(Season,''),
			isnull(IsPowder,0),
			isnull(IsLiquid,0),
			isnull(o.possessMan1,'') as possessMan1,               --美工

			isnull(s.origin1,'') as  LinkUrl4,
			isnull(s.origin2,'') as  LinkUrl5,
			isnull(s.origin3,'') as  LinkUrl6,
			isnull(isMagnetism,0),
			 case when @minPrice <=2 Then 1
				when  @minPrice >2 and @minPrice <= 5 Then 2
				when @minPrice >2 and @minPrice <= 5 Then 2
				when @minPrice >5 and @minPrice <= 10 Then 5
				when @minPrice >10 and @minPrice <= 15 Then 8
				else 10 END  as DeclareValue
																																																			--子SKU最小的零售价作为判断的基础
				 from oa_goodsinfo o
				LEFT JOIN oa_goods s ON s.nid=o.goodsid
				LEFT JOIN B_GoodsCats c on c.CategoryName=s.subCate
				LEFT JOIN B_Store e ON e.StoreName=o.StoreName
				WHERE o.pid=@pid




	SET @NewID=@@IDENTITY   --记录最近最新的nid

	--将Bgoodsid回写到oa-goods里面去
	update oa_goodsinfo set bgoodsid = @newID where pid = @pid;

	END

			if @BgoodsNumber =1 -- 开始更新数据
			BEGIN
						SET @NewID = (select bgs.nid from b_goods as bgs LEFT JOIN oa_goodsinfo as ofo on bgs.nid=ofo.bgoodsid where ofo.pid=@pid);
						update   bgs set

						bgs.GoodsCategoryID = isnull(bCats.nid,''),
						bgs.CategoryCode=isnull(bCats.CategoryCode,''),
						bgs.GoodsCode=isnull(ofo.GoodsCode,''),
						bgs.GoodsName=isnull(ofo.GoodsName,''),
            bgs.SKU =isnull(ofo.GoodsCode,'') + @SkuTail,
						bgs.MultiStyle=@MultiStyle,            --单属性是0 多属性是1
						bgs.salePrice=isnull(ogs.salePrice,0),
					  bgs.CostPrice=(SELECT isnull(MAX(u.CostPrice),0)  FROM  oa_goodssku u WHERE pid=@pid),
						bgs.AliasCnName=isnull(ofo.AliasCnName,''),
						bgs.AliasEnName=isnull(ofo.AliasEnName,''),
						bgs.Weight=(SELECT isnull(MAX(u.Weight),0)  FROM  oa_goodssku u WHERE pid=@pid),
						bgs.DeclaredValue=case when @minPrice <=2 Then 1
						when  @minPrice >2 and @minPrice <= 5 Then 2
						when @minPrice >2 and @minPrice <= 5 Then 2
						when @minPrice >5 and @minPrice <= 10 Then 5
						when @minPrice >10 and @minPrice <= 15 Then 8
						else 10 END,
						bgs.OriginCountry='China',
						bgs.OriginCountryCode='CN',
						bgs.SupplierID=isnull(ofo.SupplierID,''),
						bgs.SalerName=isnull(ogs.developer,''), 												--开发员
						bgs.PackName=isnull(ofo.PackName,''),
						bgs.GoodsStatus='在售',
						bgs.DevDate=isnull(ogs.createDate,getdate()),
						bgs.RetailPrice=(SELECT isnull(MAX(u.RetailPrice),0)  FROM  oa_goodssku u WHERE pid=@pid),
						bgs.StoreID=isnull(store.NID ,''),
						bgs.Purchaser=isnull(ofo.Purchaser,'') ,
						bgs.LinkUrl=isnull(ogs.vendor1,''),
						bgs.LinkUrl2=isnull(ogs.vendor2,''),
						bgs.LinkUrl3=isnull(ogs.vendor3,''),
						bgs.IsCharged=isnull(ofo.IsCharged,0),
						bgs.Season=isnull(ofo.Season,''),
						bgs.IsPowder=isnull(ofo.IsPowder,0),
						bgs.IsLiquid=isnull(ofo.IsLiquid,0),
						bgs.possessMan1=isnull(ofo.possessMan1,''),
						bgs.LinkUrl4=isnull(ogs.origin1,''),
						bgs.LinkUrl5=isnull(ogs.origin1,''),
						bgs.LinkUrl6=isnull(ogs.origin1,''),
						bgs.isMagnetism=isnull(ofo.isMagnetism,0)
					from b_goods  as bgs LEFT JOIN oa_goodsinfo as ofo on bgs.nid = ofo.bgoodsid
					LEFT JOIN  oa_goods as ogs on ofo.goodsid = ogs.nid
					Left Join b_goodsCats as bCats on bCats.categoryName = ogs.subCate
					LEFT JOIN B_store as store on store.storeName = ofo.StoreName
					where ofo.pid = @pid
					END


-- james  不必保存 整个回滚
 --save   tran  toBGoodsOK   --保存一个事务点命名为toBGoodsOK
if @SkuNumberDiff =0 --  没有导入过 直接创建
Begin
				--对接插入B_GoodsSKU表
				insert into B_GoodsSKU(
				GoodsID,SKU,property1,property2,property3,
				SKUName,
				BmpFileName,
				--LocationID,
				Remark,Weight,CostPrice,
				RetailPrice,
				GoodsSKUStatus
								)

				SELECT

				isnull(g.nid ,'') AS GoodsID,
				isnull(u.sku,'') AS SKU,
				isnull(u.property1,'') AS property1,
				isnull(u.property2,'') AS property2,
				isnull(u.property3,'') AS property3,
				RTRIM(RTRIM(RTRIM(o.GoodsName+' '+isnull(u.property1,''))+' '+isnull(u.property2,''))+' '+isnull(u.property3,'')) as SKUName,
				CASE WHEN CHARINDEX('_',u.sku)=0 THEN 'http://121.196.233.153/images/'+isnull(u.sku,'')+'.jpg'
				else 'http://121.196.233.153/images/'+SUBSTRING(u.sku,0,(CHARINDEX('_',u.sku)))+'.jpg'
				END as BmpFileName,
				--'http://121.196.233.153/images/'+isnull(u.sku,'')+'.jpg' as BmpFileName, --http://121.196.233.153/images/7A068901.jpg,
				--'仓库的ID' as LocationID,
				isnull(o.description,'') as Remark,
				isnull(u.Weight,0) AS Weight,
				isnull(u.CostPrice,0) AS CostPrice,
				isnull(u.RetailPrice,0) as RetailPrice,
				'在售' as GoodsSKUStatus

				FROM oa_goodssku u
				LEFT JOIN oa_goodsinfo o ON o.pid=u.pid
				LEFT JOIN B_Goods g ON g.GoodsCode= o.GoodsCode
				WHERE o.pid=@pid

				-- 将生成B_goodssku nid 会写到 oa_goodssku
			update ogsku set ogsku.goodsskuid= bgsku.nid  from oa_goodssku as ogsku
			LEFT JOIN b_goodssku as bgsku on bgsku.sku=ogsku.sku
			LEFT JOIN oa_goodsinfo  as oas on oas.pid = ogsku.pid
			where oas.pid= @pid

END

if @SkuNumberDiff >0  and @OaskuNumber = @SkuNumberDiff   --SKU已经创建过了 并且一一对应 只进行更新操作
BEGIN

update bgsku
set
bgsku.GoodsID=isnull(bgs.nid ,''),
bgsku.SKU=isnull(oasku.sku,''),
bgsku.property1=isnull(oasku.property1,''),
bgsku.property2=isnull(oasku.property2,''),
bgsku.property3=isnull(oasku.property3,''),
bgsku.SKUName=RTRIM(RTRIM(RTRIM(oas.GoodsName+' '+isnull(oasku.property1,''))+' '+isnull(oasku.property2,''))+' '+isnull(oasku.property3,'')),
bgsku.BmpFileName= CASE WHEN CHARINDEX('_',oasku.sku)=0 THEN 'http://121.196.233.153/images/'+isnull(oasku.sku,'')+'.jpg'
				else 'http://121.196.233.153/images/'+SUBSTRING(oasku.sku,0,(CHARINDEX('_',oasku.sku)))+'.jpg'
				END,
--bgsku.--LocationID,
bgsku.Remark=isnull(oas.description,''),
bgsku.Weight=isnull(oasku.Weight,0),
bgsku.CostPrice=isnull(oasku.CostPrice,0),
bgsku.RetailPrice=isnull(oasku.RetailPrice,0),
bgsku.GoodsSKUStatus='在售'

from b_goodssku as bgsku
LEFT JOIN oa_goodssku as oasku on bgsku.nid = oasku.goodsskuid
LEFT JOIN oa_goodsinfo as oas on oas.pid=oasku.pid
LEFT JOIN B_Goods  as bgs on bgs.nid = oas.bgoodsid
where oas.pid = @pid
END


if @SkuNumberDiff >0  and @OaskuNumber <> @SkuNumberDiff --sku 数量变化的时候
BEGIN
-- 查找出已经在b_goodssku里面的goodsskuid 更新之
select oasku.sid into #toUpdate  from oa_goodssku as oasku LEFT JOIN b_goodssku as bgsku on oasku.goodsskuid=bgsku.nid  where bgsku.nid is  not null  and oasku.pid=@pid

		update bgsku
set
bgsku.GoodsID=isnull(bgs.nid ,''),
bgsku.SKU=isnull(oasku.sku,''),
bgsku.property1=isnull(oasku.property1,''),
bgsku.property2=isnull(oasku.property2,''),
bgsku.property3=isnull(oasku.property3,''),
bgsku.SKUName=RTRIM(RTRIM(RTRIM(oas.GoodsName+' '+isnull(oasku.property1,''))+' '+isnull(oasku.property2,''))+' '+isnull(oasku.property3,'')),
bgsku.BmpFileName= CASE WHEN CHARINDEX('_',oasku.sku)=0 THEN 'http://121.196.233.153/images/'+isnull(oasku.sku,'')+'.jpg'
				else 'http://121.196.233.153/images/'+SUBSTRING(oasku.sku,0,(CHARINDEX('_',oasku.sku)))+'.jpg'
				END,
--bgsku.--LocationID,
bgsku.Remark=isnull(oas.description,''),
bgsku.Weight=isnull(oasku.Weight,0),
bgsku.CostPrice=isnull(oasku.CostPrice,0),
bgsku.RetailPrice=isnull(oasku.RetailPrice,0),
bgsku.GoodsSKUStatus='在售'

from b_goodssku as bgsku
LEFT JOIN oa_goodssku as oasku on bgsku.nid = oasku.goodsskuid
LEFT JOIN oa_goodsinfo as oas on oas.pid=oasku.pid
LEFT JOIN B_Goods  as bgs on bgs.nid = oas.bgoodsid
where oasku.sid in (select * from #toUpdate)


-- 查找出不在B_goodssku里面的goodsskuid 创建之
	select oasku.sid into #toCreate from oa_goodssku as oasku LEFT JOIN b_goodssku as bgsku on oasku.goodsskuid=bgsku.nid  where bgsku.nid is null  and oasku.pid=@pid
				insert into B_GoodsSKU(
				GoodsID,SKU,property1,property2,property3,
				SKUName,
				BmpFileName,
				--LocationID,
				Remark,Weight,CostPrice,
				RetailPrice,
				GoodsSKUStatus
								)

				SELECT

				isnull(g.nid ,'') AS GoodsID,
				isnull(u.sku,'') AS SKU,
				isnull(u.property1,'') AS property1,
				isnull(u.property2,'') AS property2,
				isnull(u.property3,'') AS property3,
				RTRIM(RTRIM(RTRIM(o.GoodsName+' '+isnull(u.property1,''))+' '+isnull(u.property2,''))+' '+isnull(u.property3,'')) as SKUName,
				CASE WHEN CHARINDEX('_',u.sku)=0 THEN 'http://121.196.233.153/images/'+isnull(u.sku,'')+'.jpg'
				else 'http://121.196.233.153/images/'+SUBSTRING(u.sku,0,(CHARINDEX('_',u.sku)))+'.jpg'
				END as BmpFileName,
				--'http://121.196.233.153/images/'+isnull(u.sku,'')+'.jpg' as BmpFileName, --http://121.196.233.153/images/7A068901.jpg,
				--'仓库的ID' as LocationID,
				isnull(o.description,'') as Remark,
				isnull(u.Weight,0) AS Weight,
				isnull(u.CostPrice,0) AS CostPrice,
				isnull(u.RetailPrice,0) as RetailPrice,
				'在售' as GoodsSKUStatus

				FROM oa_goodssku u
				LEFT JOIN oa_goodsinfo o ON o.pid=u.pid
				LEFT JOIN B_Goods g ON g.GoodsCode= o.GoodsCode
				WHERE u.sid in (select * from #toCreate)

				-- 将生成B_goodssku nid 回写到 oa_goodssku
			update ogsku set ogsku.goodsskuid= bgsku.nid  from oa_goodssku as ogsku
			LEFT JOIN b_goodssku as bgsku on bgsku.sku=ogsku.sku
			LEFT JOIN oa_goodsinfo  as ofo on ofo.pid = ogsku.pid
			where ogsku.sid in (select * from #tocreate)

	    --


drop table #toUpdate
dRop table #toCreate
END

-- 如果这个产品是特殊属属性则B_GoodsAttribute 插入 这条记录
--INSERT INTO B_GoodsAttribute (GoodsID,AttributeName) 创建或更新
DECLARE @AttributeName VARCHAR(60);
SET @AttributeName = (SELECT AttributeName FROM oa_goodsinfo WHERE pid=@pid)

		IF  @AttributeName<>''
	BEGIN
		delete from B_GoodsAttribute where GoodsID=@NewID
		insert into B_GoodsAttribute(GoodsID, AttributeName) VALUES (@NewID,@AttributeName)
	END

	--根据GoodsID 插入KC_CurrentStock 创建或更新产品

	DELETE from KC_CurrentStock where GoodsID = @NewID
	insert into KC_CurrentStock (
	StoreID,
	GoodsSKUID,
	GoodsID
	)
	select
isnull(bs.nid,'') as StoreID,
isNull(gs.nid,'') as GoodsSKUID,
isnull(gs.GoodsID,'') as GoodsID
 from b_goods as g
	LEFT JOIN B_GoodsSKU as gs ON gs.goodsid=g.nid
	LEFT JOIN B_Store as bs on g.StoreID=bs.NID
	where gs.GoodsID=@NewID


if  @@error<>0  --判断插入没有出错

								 begin --如果出错

												--rollback   tran  toBGoodsOK  -- toBGoodsOK 的还原点

										 rollback   tran  toBGoods  --提交事务

								 end

           else  --没有出错

						commit  tran toBGoods --提交事务


END