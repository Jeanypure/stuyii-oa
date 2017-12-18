ALTER PROCEDURE [dbo].[Z_P_DevNetprofit]
  @DateFlag int,                         --时间标记 0 交易时间 1 发货时间
  @BeginDate	varchar(20),               --开始时间
  @EndDate	Varchar(20),               --结束时间
  @Sku		Varchar(100),              --SKU
  @SalerName VARCHAR(max),                --业绩归属人1
  @SalerName2 VARCHAR(50),               --业绩归属人2
  @chanel VARCHAR(50),                   --销售渠道
  @SaleType VARCHAR(50),	               --销售类型
  @SalerAliasName VARCHAR(max) = '',     --卖家简称 可以用逗号分隔
  @DevDate varchar(20),                  --商品开发时间--开始时间
  @DevDateEnd varchar(20),               --商品开发时间--结束时间
  @Purchaser VARCHAR(50),                --采购员
  @SupplierName VARCHAR(50),                --供应商
  @possessMan1 VARCHAR(50),                --责任归属人1
  @possessMan2 VARCHAR(50),               --责任归属人2
  @UserIDtemp int=0
AS
begin

  SET NOCOUNT ON
  set @BeginDate	=	SUBSTRING(@BeginDate,1,10)
  set @EndDate	=	SUBSTRING(@EndDate,1,10)
  if @DateFlag=0
    begin
      set @BeginDate	=	DATEADD(HH,-8,@BeginDate)
      set @EndDate	=	DATEADD(HH,-8,dateadd(DD,1,@EndDate))
    end

  CREATE TABLE #tbSalerName( salername VARCHAR(100))
  IF LTRIM(RTRIM(@salername)) <> ''
    BEGIN
      DECLARE @sSQLCmd VARCHAR(max) = ''
      set @SalerName=''''+@SalerName+''''
      SET @salername = REPLACE(@salername,',','''))UNION SELECT ltrim(rtrim(''')
      SET @sSQLCmd = 'INSERT INTO #tbSalerName(salername) SELECT ltrim(rtrim('+ @salername+'))'
      EXEC(@sSQLCmd )
    END
  --select * from #tbSalerName
  CREATE TABLE #tbSalerAliasName( SalerAliasName VARCHAR(100) )
  DECLARE @SelDataUser VARCHAR(Max),
  @SqlCmd VARCHAR(Max),
  @Username VARCHAR(200),
  @devRate VARCHAR(10)= isnull((select devRate from Y_Ratemanagement) ,'')
  -- 现在@UserID=0 就是admin
  if @UserIDtemp=0
    begin
      set @Username='admin'
    end
  else
    begin
      set @Username=isnull((select top 1 USERID from S_SystemUser where NID=@UserIDtemp),'')
    end
  if LOWER(@Username)='admin'
    begin
      --分解卖家简称放到表格里
      IF LTRIM(RTRIM(@SalerAliasName)) <> ''
        BEGIN
          set @SalerAliasName=''''+@SalerAliasName+''''
          SET @SalerAliasName = REPLACE(@SalerAliasName,',','''))UNION SELECT ltrim(rtrim(''')
          SET @SqlCmd = 'INSERT INTO #tbSalerAliasName(SalerAliasName) SELECT ltrim(rtrim('+ @SalerAliasName+'))'
          EXEC(@SqlCmd )
        END
    end
  else
    begin
      --分解卖家简称放到表格里
      IF LTRIM(RTRIM(@SalerAliasName)) <> ''
        BEGIN
          set @SalerAliasName=''''+@SalerAliasName+''''
          SET @SalerAliasName = REPLACE(@SalerAliasName,',','''))UNION SELECT ltrim(rtrim(''')
          SET @SqlCmd = 'INSERT INTO #tbSalerAliasName(SalerAliasName) SELECT ltrim(rtrim('+ @SalerAliasName+'))'
          EXEC(@SqlCmd )
        END
      else
        begin
          -- 取有权限的几个账号
          set @SalerAliasName='非admin'
          SET @SelDataUser = ISNULL((SELECT SelDataUser
                                     FROM B_Person WHERE NID = @UserIDtemp),'')
          IF (ISNULL(@SelDataUser,'') = '') SET @SelDataUser = ''''
          SET @SqlCmd = 'insert into #tbSalerAliasName(SalerAliasName) SELECT spsi.NoteName '
                        +' FROM S_PalSyncInfo spsi WHERE spsi.NoteName IN ('+@SelDataUser+')'
                        +' UNION SELECT DictionaryName FROM  B_Dictionary WHERE (CategoryID = 12)'
                        +'  AND DictionaryName IN ('+@SelDataUser+')'
          EXECUTE(@SqlCmd)

        end
    end


  declare @Sql varchar(max)

  -- 创建临时表用来存储信息
  create Table #TmpTradeInfo(
    Nid int not null,                          --订单号
    AllWeight float Null,                      --总重量
    AllQty int Null,                           --总数量
    amt float null,                            --总销售金额
    SHIPPINGAMT float null,                    --买家付运费
    SHIPDISCOUNT float null,                   --ebay交易费
    FeeAmt float null,                         --交易费(pp手续费)
    ExpressFare float null,                    --快递费
    INSURANCEAMOUNT float null,                --包装费
    SKUPACKFEE float null,                     --SKU包装费
    SKU varchar(100) null,                     --SKU
    SKUQty int null,                           --Sku数量
    SKUWeight float null,                      --SKU重量
    SKUCostPrice float null,                   --订单SKU成本价
    SKUamt float null,                         --订单SKU销售金额
    ExchangeRate float null,                   --汇率
    goodsid int null                           --商品ID
  )
  create Table #TmpSkuFreeInfo(
    SKU varchar(100)  null,                    --SKU
    SKUQty int null,                           --Sku数量
    SaleMoneyRmb float null,                   --SKU 销售金额￥
    ShippingAmtRmb float null,                 --SKU 买家付运费￥
    CostMoneyRmb float null,                   --SKU 销售成本￥
    eBayFeeRmb float null,                     --SKU ebay成交费￥
    PaypalFeeRmb float null,                   --SKU PP手续费￥
    ExpressFareRmb float null,                 --SKU 运费成本￥
    InPackageFeeRmb float null,                --SKU 包装成本￥
    OutPackageFeeRmb float null,               --SKU 外包装成本￥
  )
  create Table #TmpSumSkuFreeInfo(
    SKU varchar(100)  null,                    --SKU
    SKUQty int null,                           --销售数量
    SaleMoneyRmb float null,                   --成交价￥
    ShippingAmtRmb float null,                 --买家付运费￥
    CostMoneyRmb float null,                   --销售成本￥
    ProfitRmb float null,                      --实收利润￥
    eBayFeeRmb float null,                     --ebay成交费￥
    PaypalFeeRmb float null,                   --PP手续费￥
    ExpressFareRmb float null,                 --运费成本￥
    InPackageFeeRmb float null,                  --包装成本￥
    OutPackageFeeRmb float null,               --外包装成本￥
    AverageSaleMoneyRmb float null,            --平均售价￥
    AverageProfitRmb float null                --平均利润价￥
  )

  --查找美元的汇率
  Declare  @ExchangeRate float
  set @ExchangeRate =ISNULL((select ExchangeRate from B_CurrencyCode  where CURRENCYCODE='USD'),1)

  --查找成本计价方法
  Declare @CalcCostFlag int
  set @CalcCostFlag =ISNULL((select ParaValue from B_SysParams where ParaCode ='CalCostFlag'),0)
  -- 重寄单数据 不行 重寄单会自动删除
  --select m.OrderNumber as nid into #Tmpchongji from XS_SaleAfterM m
  --  where m.SaleType='重寄'

  --正常表的数据插入数据库
  insert into #TmpTradeInfo
    select m.Nid,                                                                        --订单号
      isnull((select Sum(IsNull(a.Weight,0))
              from p_tradedt(nolock) a where a.tradenid = m.nid),0) as allweight ,  --总重量
      isnull((select Sum(IsNull(a.L_QTY,0))
              from p_tradedt(nolock) a where a.tradenid = m.nid),0) as AllQty ,     --总数量
      isnull((select Sum(IsNull(a.l_amt,0))
              from p_tradedt(nolock) a where a.tradenid = m.nid),0) as amt,         --总销售金额
      case when ISNULL(m.AMT,0)=0 then 0 else m.SHIPPINGAMT end,  --买家付运费 特殊运费
      m.SHIPDISCOUNT ,      --ebay交易费 wish特殊，有数值也为0
      m.FeeAmt
      ,                                  --交易费(pp手续费) wish特殊,（商品金额+运费总额/0.85）*0.18
      m.ExpressFare,                                                                --快递费
      m.INSURANCEAMOUNT,                                                            --包装费
      case when d.L_TAXAMT=0 then d.L_QTY*ISNULL(bg.PackFee,0)
      else d.L_TAXAMT*0 end,                                                   --SKU包装费
      d.sku,                                                                        --SKU
      d.l_qty,                                                                      --SKU数量
      d.weight,                                                                     --SKU重量
      case when @CalcCostFlag =0 then d.CostPrice
      else d.L_QTY*(case when bgs.costprice<>0 then bgs.costprice
                    else isnull(bg.CostPrice,0) end ) end as SKUCostPrice,                   --订单SKU成本价
      case when ISNULL(m.AMT,0)=0 then 0 else d.l_amt end,                                                                      --订单SKU销售金额
      isnull(c.ExchangeRate,1),                                                     --汇率
      bg.nid as goodsid                                                             --商品ID
    FROM  p_tradedt(nolock) d
      inner join p_trade(nolock) m on m.nid=d.tradenid
      LEFT JOIN B_GoodsSKU bgs ON isnull(d.SKU,'')=bgs.SKU
      LEFT JOIN B_Goods bg ON bgs.GoodsID = bg.NID
      left join B_CurrencyCode c on c.currencycode=m.currencycode
    where  ((@DateFlag=1 and m.FilterFlag=100 and convert(varchar(10),m.CLOSINGDATE,121) between @BeginDate and @endDate)
            or  (@DateFlag=0 and m.ORDERTIME between @BeginDate and @endDate) )
           AND (@Sku = '' or  isnull(d.SKU,'') like '%'+ @Sku+'%')                                          --SKU
           AND (ISNULL(@SalerAliasName,'') = '' OR m.SUFFIX IN (SELECT SalerAliasName FROM #tbSalerAliasName))	   --卖家简称
           AND (ISNULL(@chanel,'') = '' OR isnull(m.TRANSACTIONTYPE,'') = @chanel)              --交易类型
           AND (ISNULL(@SaleType,'') = '' OR isnull(m.SALUTATION,'') = @SaleType) 	           --销售类型
           --AND ((ISNULL(@SalerName,'') = '0') OR (isnull(bg.SalerName,'') in (select Personname from B_Person where NID=@SalerName)))
           --AND ((ISNULL(@SalerName2,'') = '0') OR (isnull(bg.SalerName2,'') in (select Personname from B_Person where NID=@SalerName2)))
           AND ((ISNULL(@possessMan1,'') = '0') OR (isnull(bg.possessMan1,'') in (select Personname from B_Person where NID=@possessMan1)))
           AND ((ISNULL(@possessMan2,'') = '0') OR (isnull(bg.possessMan2,'') in (select Personname from B_Person where NID=@possessMan2)))
           AND ((ISNULL(@Purchaser,'') = '0') OR (isnull(bg.Purchaser,'') in (select Personname from B_Person where NID=@Purchaser)))
           AND ((ISNULL(@SupplierName,'') = '0') OR (isnull(bg.SupplierID,'')=@SupplierName))
           and (ISNULL(@DevDate,'') ='' or
                (convert(varchar(10),bg.DevDate,121) >= @DevDate
                 and convert(varchar(10),bg.DevDate,121) <= @DevDateEnd))



  --历史表的数据插入数据库 不用判断发货状态  m.FilterFlag = 10
  insert into #TmpTradeInfo
    select m.Nid,                                                                            --订单号
      isnull((select Sum(IsNull(a.Weight,0))
              from p_tradedt_his(nolock) a where a.tradenid = m.nid),0) as allweight ,  --总重量
      isnull((select Sum(IsNull(a.L_QTY,0))
              from p_tradedt_his(nolock) a where a.tradenid = m.nid),0) as AllQty ,     --总数量
      isnull((select Sum(IsNull(a.l_amt,0))
              from p_tradedt_his(nolock) a where a.tradenid = m.nid),0) as amt,     --总销售金额
      case when ISNULL(m.AMT,0)=0 then 0 else m.SHIPPINGAMT end ,  --买家付运费 特殊运费
      m.SHIPDISCOUNT ,      --ebay交易费 wish特殊，有数值也为0
      m.FeeAmt
      ,                                  --交易费(pp手续费) wish特殊,（商品金额+运费总额/0.85）*0.18
      m.ExpressFare,                                                                --快递费
      m.INSURANCEAMOUNT,                                                            --包装费
      case when d.L_TAXAMT=0 then d.L_QTY*ISNULL(bg.PackFee,0)
      else d.L_TAXAMT*0 end,                                                   --SKU包装费
      d.sku,                                                                        --SKU
      d.l_qty,                                                                      --SKU数量
      d.weight,                                                                     --SKU重量
      case when @CalcCostFlag =0 then d.CostPrice
      else d.L_QTY*(case when bgs.costprice<>0 then bgs.costprice
                    else isnull(bg.CostPrice,0) end ) end as SKUCostPrice,                   --订单SKU成本价
      case when ISNULL(m.AMT,0)=0 then 0 else d.l_amt end,                                                                       --订单SKU销售金额
      isnull(c.ExchangeRate,1),                                                     --汇率
      bg.nid as goodsid                                                             --商品ID
    FROM  p_tradedt_his(nolock) d
      inner join p_trade_his(nolock) m on m.nid=d.tradenid
      LEFT JOIN B_GoodsSKU bgs ON isnull(d.SKU,'')=bgs.SKU
      LEFT JOIN B_Goods bg ON bgs.GoodsID = bg.NID
      left join B_CurrencyCode c on c.currencycode=m.currencycode
    where  ((@DateFlag=1 and  convert(varchar(10),m.CLOSINGDATE,121) between @BeginDate and @endDate)
            or  (@DateFlag=0 and m.ORDERTIME between @BeginDate and @endDate) )
           AND (@Sku = '' or  isnull(d.SKU,'') like '%'+ @Sku+'%')                                          --SKU
           AND (ISNULL(@SalerAliasName,'') = '' OR m.SUFFIX IN (SELECT SalerAliasName FROM #tbSalerAliasName))	   --卖家简称
           AND (ISNULL(@chanel,'') = '' OR isnull(m.TRANSACTIONTYPE,'') = @chanel)              --交易类型
           AND (ISNULL(@SaleType,'') = '' OR isnull(m.SALUTATION,'') = @SaleType) 	           --销售类型
           --AND ((ISNULL(@SalerName,'') = '0') OR (isnull(bg.SalerName,'') in (select Personname from B_Person where NID=@SalerName)))
           --AND ((ISNULL(@SalerName2,'') = '0') OR (isnull(bg.SalerName2,'') in (select Personname from B_Person where NID=@SalerName2)))
           AND ((ISNULL(@possessMan1,'') = '0') OR (isnull(bg.possessMan1,'') in (select Personname from B_Person where NID=@possessMan1)))
           AND ((ISNULL(@possessMan2,'') = '0') OR (isnull(bg.possessMan2,'') in (select Personname from B_Person where NID=@possessMan2)))
           AND ((ISNULL(@Purchaser,'') = '0') OR (isnull(bg.Purchaser,'') in (select Personname from B_Person where NID=@Purchaser)))
           AND ((ISNULL(@SupplierName,'') = '0') OR (isnull(bg.SupplierID,'')=@SupplierName))
           and (ISNULL(@DevDate,'') ='' or
                (convert(varchar(10),bg.DevDate,121) >= @DevDate
                 and convert(varchar(10),bg.DevDate,121) <= @DevDateEnd))


  --更新总重量和总金额,总数量如果是0 那么改成1
  update #TmpTradeInfo set allweight = 1 where ISNULL(allweight,0) = 0
  update #TmpTradeInfo set amt = 1 where ISNULL(amt,0) = 0
  update #TmpTradeInfo set AllQty = 1 where ISNULL(AllQty,0) = 0
  --select * from #TmpTradeInfo
  --计算金额并插入临时表
  --SKU 销售金额￥    = SKU费用 * 币种汇率
  --SKU 买家付运费￥  = (买家付运费 * 币种汇率) * SKU重量 / 总重量
  --SKU 销售成本￥    = 订单SKU成本价
  --SKU ebay成交费￥  = (ebay交易费 * 美元汇率) * SKU费用 / 总费用
  --SKU PP手续费￥    = (pp手续费 * 币种汇率) * SKU费用 / 总费用
  --SKU 运费成本￥    = 快递费 * SKU重量 / 总重量
  --SKU 包装成本￥    = (包装费 * 1.0) * SKU数量 / 总数量 + sku包装费
  insert into #TmpSkuFreeInfo
    select SKU,                                                    --SKU
      SKUQty ,                                                --Sku数量
      SKUamt * ExchangeRate,                                  --SKU 销售金额￥
      (SHIPPINGAMT * ExchangeRate) * SKUamt/amt,             --SKU 买家付运费￥
      SKUCostPrice ,                                          --SKU 销售成本￥
      (SHIPDISCOUNT * @ExchangeRate) * SKUamt/amt,            --SKU ebay成交费￥
      (FeeAmt * ExchangeRate) * SKUamt/amt,                   --SKU PP手续费￥
      ExpressFare * SKUWeight / AllWeight,                    --SKU 运费成本￥
      SKUPACKFEE,                                             --SKU 内包装成本￥
      (INSURANCEAMOUNT * 1.0) * SKUQty / AllQty                --sku 外包装成本
    from #TmpTradeInfo
  --select * from #TmpSkuFreeInfo
  --统计金额插入临时表
  --成交价￥       = sum(SKU 销售金额￥ + SKU 买家付运费￥)
  --买家付运费￥   = sum(SKU 买家付运费￥)
  --销售成本￥     = sum(SKU 销售成本￥)
  --实收利润￥     = sum(SKU 销售金额￥ + SKU 买家付运费￥ - SKU 销售成本￥ - SKU ebay成交费￥
  --                     - SKU PP手续费￥ - SKU 运费成本￥ - SKU 包装成本￥)
  --ebay成交费￥   = sum(SKU ebay成交费￥)
  --PP手续费￥     = sum(SKU PP手续费￥)
  --运费成本￥     = sum(SKU 运费成本￥)
  --包装成本￥     = sum(SKU 包装成本￥)
  --平均售价￥     = 成交价￥ / sum(Sku数量)
  --平均利润价￥   = 实收利润￥ / sum(Sku数量)
  insert into #TmpSumSkuFreeInfo
    select SKU,                                                  --SKU
      SKUQty,                                               --销售数量
      SaleMoneyRmb,                                         --成交价￥
      ShippingAmtRmb,                                       --买家付运费￥
      CostMoneyRmb,                                         --销售成本￥
      ProfitRmb,                                            --实收利润￥
      eBayFeeRmb  ,                                         --ebay成交费￥
      PaypalFeeRmb ,                                        --PP手续费￥
      ExpressFareRmb ,                                      --运费成本￥
      InPackageFeeRmb ,                                     --内包装成本￥
      OutPackageFeeRmb ,                                       --外包装成本￥
      case when SKUQty = 0 then 0
      else SaleMoneyRmb/SKUQty end,                    --平均售价￥
      case when SKUQty = 0 then 0
      else ProfitRmb/SKUQty end                        --平均利润价￥
    from
      (select SKU,                                                  --SKU
         sum(SKUQty) as SKUQty,                                --数量
         SUM(SaleMoneyRmb + ShippingAmtRmb) as SaleMoneyRmb,   --成交价￥
         SUM(ShippingAmtRmb) as ShippingAmtRmb,                --买家付运费￥
         SUM(CostMoneyRmb) as CostMoneyRmb,                    --销售成本￥
         SUM(SaleMoneyRmb + ShippingAmtRmb - CostMoneyRmb
             - eBayFeeRmb - PaypalFeeRmb - ExpressFareRmb
             - InPackageFeeRmb-OutPackageFeeRmb) as ProfitRmb,   --实收利润￥
         SUM(eBayFeeRmb) as eBayFeeRmb  ,                      --ebay成交费￥
         SUM(PaypalFeeRmb) as PaypalFeeRmb ,                   --PP手续费￥
         SUM(ExpressFareRmb) as ExpressFareRmb ,               --运费成本￥
         SUM(InPackageFeeRmb) as InPackageFeeRmb,                   --内包装成本￥
         SUM(OutPackageFeeRmb) as OutPackageFeeRmb                   --外包装成本￥
       from #TmpSkuFreeInfo
       group by SKU) aa
  --select * from #TmpSumSkuFreeInfo
  --最后关联统计
  --#DevGrossProfit 包含所有信息

  select
    isnull(fg.SKU,'') as 'SKU',
    isnull(g.GoodsCode,'') as 'GoodsCode',                        -- '商品编码',
    isnull(g.GoodsName,'') as  'GoodsName',                       --'商品名称',
    isnull(abgs.CategoryName,'') as 'CategoryName',              -- '管理类别',
    ISNULL(gs.GoodsSKUStatus,'') as 'GoodsSKUStatus',             --'商品SKU状态',
    isnull(g.CreateDate,'') as 'CreateDate',										   -- '创建日期',
    g.SalerName as  'SalerName',																   --'业绩归属1',
    g.SalerName2 as 'SalerName2', 															   --'业绩归属2',
    isnull(g.Purchaser,'') as 'Purchaser',                       -- '采购员',
    (select SUM(isnull(Number,0)) from kc_currentstock where GoodsSKUID=gs.NID) as 'Number',--'库存数量',
    fg.SKUQty as 'SKUQty', 																  	   --'销售数量',
    round(fg.CostMoneyRmb,2) as 'CostMoneyRmb' ,                  --'商品成本￥',
    round(fg.SaleMoneyRmb,2) as 'SaleMoneyRmb',                   --'销售额￥',
    round(fg.CostMoneyRmb,2) as 'CostMoneyRmbSaler',                   --'销售成本￥',
    round(fg.PaypalFeeRmb,2) as 'PaypalFeeRmb',                   --'PP手续费￥',
    round(fg.eBayFeeRmb,2) as 'eBayFeeRmb',	                     -- 'ebay成交费￥',
    round(fg.InPackageFeeRmb,2) as  'InPackageFeeRmb' ,           --'内包装成本￥',
    round(fg.OutPackageFeeRmb,2) as 'OutPackageFeeRmb' ,          --'外包装成本￥',
    round(fg.ExpressFareRmb,2) as  'ExpressFareRmb' ,             --'运费成本￥',
    round(fg.ProfitRmb,2) as 'ProfitRmb',                         --'实收利润￥',
    --	g.possessMan1 as 'possessMan1' ,                              -- '责任归属人1',
    --	g.possessMan2 as 'possessMan2',                               -- '责任归属人2',

    round(case when isnull(fg.SaleMoneyRmb,0)=0 then 0 else fg.ProfitRmb*100/fg.SaleMoneyRmb end,2) as 'profitRate' --'利润率%'
  INTO #DevGrossProfit
  from #TmpSumSkuFreeInfo fg
    left join B_GoodsSKU gs on gs.SKU=fg.sku
    left join B_goods g on gs.GoodsID=g.NID
    left join B_GoodsCats abgs on abgs.NID=g.GoodsCategoryID
  --select * from #devGrossprofit
  --#DevGrossProfit	这里数都是对的


  --业绩归属人1的清仓表 满足交易时间段
  select dev1.salername,dev1.timegroup,sum(dev1.amount)as Amount
  INTO #devOfflinefee
  from
    (SELECT
       SalerName,
       timegroup,
       sum(amount) as amount,
       devClearnTime
     FROM Y_devOfflineClearn
     WHERE devClearnTime  BETWEEN @BeginDate  AND @EndDate
     group by salername,timegroup,devClearnTime) dev1
  group  by dev1.salername,dev1.timegroup


  --select * from #devOfflinefee
  --业绩归属人1的运营费用 满足交易时间段
  select dev1.salername,dev1.timegroup,sum(dev1.amount)as Amount
  INTO #dev1OperateFee
  from
    (SELECT
       SalerName,
       timegroup,
       sum(amount) as amount,
       devOperateTime
     FROM Y_devOperateFee
     WHERE devOperateTime  BETWEEN @BeginDate  AND @EndDate
     group by salername,timegroup,devOperateTime) dev1
  group  by dev1.salername,dev1.timegroup
  --select * from #dev1OperateFee

  --0-6个月的产品 归属人1
  SELECT
      '0-6月' as 'TimeGroup' ,
    ss.SalerName,
    --ss.SalerName2,
      cast(SUM(SaleMoneyRmb) / @ExchangeRate as DECIMAL(10,2)) as SaleMoneyRmbUS,              	 	--销售额$
      cast((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate  as DECIMAL(10,2)) as SaleMoneyRmbZn ,  	--销售额￥
      cast(SUM(CostMoneyRmb) as DECIMAL(10,2)) as CostMoneyRmb,	    															--商品成本
      cast(SUM(PPebay) / @ExchangeRate as DECIMAL(10,2)) as PPebayUS,                           --手续费$
      cast((SUM(PPebay) / @ExchangeRate) * @devRate as DECIMAL(10,2)) as PPebayZn,              --手续费￥
      cast(SUM(InPackageFeeRmb) as DECIMAL(10,2)) as InPackageFeeRmb,                           --包装成本
      cast(SUM(ExpressFareRmb) as DECIMAL(10,2)) as ExpressFareRmb                              --运费成本
    ,cast(isnull(dof.Amount,0) as DECIMAL(10,2)) as 'devOfflineFee'														--死库费用
    ,cast(isnull(dpf.Amount,0) as DECIMAL(10,2)) as 'devOpeFee'																--运营杂费
    ,cast(
          (SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
          -SUM(CostMoneyRmb)
          -(SUM(PPebay) / @ExchangeRate) * @devRate
          -SUM(InPackageFeeRmb)
          -SUM(ExpressFareRmb)
          -isnull(dof.Amount,0)
          -isnull(dpf.Amount,0)

          as DECIMAL(10,2)) as NetProfit                                        --毛利润
    , cast( 100*((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
                 -SUM(CostMoneyRmb)
                 -(SUM(PPebay) / @ExchangeRate) * @devRate
                 -SUM(InPackageFeeRmb)
                 -SUM(ExpressFareRmb)
                 -isnull(dof.Amount,0)-isnull(dpf.Amount,0))/((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate) as DECIMAL(10,2)) as netRate                                                                     --毛利率
  INTO #ZeroToSixM
  from
    (
      select
        CreateDate,
        SalerName,
        --SalerName2,
        sum(CostMoneyRmb) as	CostMoneyRmb,
        sum(SaleMoneyRmb) as SaleMoneyRmb,
        sum(CostMoneyRmbSaler) as CostMoneyRmbSaler,
        sum(PaypalFeeRmb+eBayFeeRmb)  as PPebay ,
        sum(InPackageFeeRmb) as InPackageFeeRmb,
        sum(ExpressFareRmb) as ExpressFareRmb,
        sum(ProfitRmb) as ProfitRmb

      from #DevGrossProfit
      WHERE ISNULL(CreateDate, '') BETWEEN CONVERT(VARCHAR(10),DATEADD(dd, -180, @EndDate),121) AND @EndDate
      GROUP BY
        CreateDate,
        SalerName
    ) ss
    LEFT JOIN #devOfflinefee dof ON dof.salername = ss.SalerName AND dof.TimeGroup='0-6月'
    LEFT JOIN #dev1OperateFee dpf ON dpf.salername = ss.SalerName AND dpf.TimeGroup='0-6月'
  group by
    ss.SalerName,isnull(dof.Amount,0),isnull(dpf.Amount,0)

  --SELECT * from #ZeroToSixM

  --6-12月 归属人1
  SELECT
      '6-12月' as 'TimeGroup' ,
    ss.SalerName,
    --ss.SalerName2,
      cast(SUM(SaleMoneyRmb) / @ExchangeRate as DECIMAL(10,2)) as SaleMoneyRmbUS,              	 	--销售额$
      cast((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate  as DECIMAL(10,2)) as SaleMoneyRmbZn ,  	--销售额￥
      cast(SUM(CostMoneyRmb) as DECIMAL(10,2)) as CostMoneyRmb,	    															--商品成本
      cast(SUM(PPebay) / @ExchangeRate as DECIMAL(10,2)) as PPebayUS,                           --手续费$
      cast((SUM(PPebay) / @ExchangeRate) * @devRate as DECIMAL(10,2)) as PPebayZn,              --手续费￥
      cast(SUM(InPackageFeeRmb) as DECIMAL(10,2)) as InPackageFeeRmb,                           --包装成本
      cast(SUM(ExpressFareRmb) as DECIMAL(10,2)) as ExpressFareRmb                              --运费成本
    ,cast(isnull(dof.Amount,0) as DECIMAL(10,2)) as 'devOfflineFee'														--死库费用
    ,cast(isnull(dpf.Amount,0) as DECIMAL(10,2)) as 'devOpeFee'																--运营杂费
    ,cast(
          (SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
          -SUM(CostMoneyRmb)
          -(SUM(PPebay) / @ExchangeRate) * @devRate
          -SUM(InPackageFeeRmb)
          -SUM(ExpressFareRmb)
          -isnull(dof.Amount,0)
          -isnull(dpf.Amount,0)

          as DECIMAL(10,2)) as NetProfit                                        --毛利润
    , cast( 100*((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
                 -SUM(CostMoneyRmb)
                 -(SUM(PPebay) / @ExchangeRate) * @devRate
                 -SUM(InPackageFeeRmb)
                 -SUM(ExpressFareRmb)
                 -isnull(dof.Amount,0)-isnull(dpf.Amount,0))/((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate) as DECIMAL(10,2)) as netRate
  --毛利率
  INTO #SixToTweM
  from
    (
      select
        CreateDate,
        SalerName,
        --SalerName2,
        sum(CostMoneyRmb) as	CostMoneyRmb,
        sum(SaleMoneyRmb) as SaleMoneyRmb,
        sum(CostMoneyRmbSaler) as CostMoneyRmbSaler,
        sum(PaypalFeeRmb+eBayFeeRmb)  as PPebay ,
        sum(InPackageFeeRmb) as InPackageFeeRmb,
        sum(ExpressFareRmb) as ExpressFareRmb,
        sum(ProfitRmb) as ProfitRmb

      from #DevGrossProfit
      WHERE ISNULL(CreateDate, '') BETWEEN CONVERT(VARCHAR(10),DATEADD(dd, -360, @EndDate),121) AND CONVERT(VARCHAR(10),DATEADD(dd, -180, @EndDate),121)
      GROUP BY


        CreateDate,
        SalerName
      --SalerName2
    ) ss
    LEFT JOIN #devOfflinefee dof ON dof.salername = ss.SalerName AND dof.TimeGroup='6-12月'
    LEFT JOIN #dev1OperateFee dpf ON dpf.salername = ss.SalerName AND dpf.TimeGroup='6-12月'

  group by
    ss.SalerName,isnull(dof.Amount,0),isnull(dpf.Amount,0)

  --select * FROM #SixToTweM

  --12月以上 归属人1
  SELECT
      '12月以上' as 'TimeGroup' ,
    ss.SalerName,
    --ss.SalerName2,
      cast(SUM(SaleMoneyRmb) / @ExchangeRate as DECIMAL(10,2)) as SaleMoneyRmbUS,              	 	--销售额$
      cast((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate  as DECIMAL(10,2)) as SaleMoneyRmbZn ,  	--销售额￥
      cast(SUM(CostMoneyRmb) as DECIMAL(10,2)) as CostMoneyRmb,	    															--商品成本
      cast(SUM(PPebay) / @ExchangeRate as DECIMAL(10,2)) as PPebayUS,                           --手续费$
      cast((SUM(PPebay) / @ExchangeRate) * @devRate as DECIMAL(10,2)) as PPebayZn,              --手续费￥
      cast(SUM(InPackageFeeRmb) as DECIMAL(10,2)) as InPackageFeeRmb,                           --包装成本
      cast(SUM(ExpressFareRmb) as DECIMAL(10,2)) as ExpressFareRmb                              --运费成本
    ,cast(isnull(dof.Amount,0) as DECIMAL(10,2)) as 'devOfflineFee'						--死库费用
    ,cast(isnull(dpf.Amount,0) as DECIMAL(10,2)) as 'devOpeFee'																--运营杂费
    ,cast(
          (SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
          -SUM(CostMoneyRmb)
          -(SUM(PPebay) / @ExchangeRate) * @devRate
          -SUM(InPackageFeeRmb)
          -SUM(ExpressFareRmb)
          -isnull(dof.Amount,0)
          -isnull(dpf.Amount,0)
          as DECIMAL(10,2)) as NetProfit                                        --毛利润
    , cast( 100*((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
                 -SUM(CostMoneyRmb)
                 -(SUM(PPebay) / @ExchangeRate) * @devRate
                 -SUM(InPackageFeeRmb)
                 -SUM(ExpressFareRmb)
                 -isnull(dof.Amount,0)-isnull(dpf.Amount,0))/((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate) as DECIMAL(10,2)) as netRate
  --毛利率
  INTO #AboveTwe
  from
    (
      select
        CreateDate,
        SalerName,
        --SalerName2,
        sum(CostMoneyRmb) as	CostMoneyRmb,
        sum(SaleMoneyRmb) as SaleMoneyRmb,
        sum(CostMoneyRmbSaler) as CostMoneyRmbSaler,
        sum(PaypalFeeRmb+eBayFeeRmb)  as PPebay ,
        sum(InPackageFeeRmb) as InPackageFeeRmb,
        sum(ExpressFareRmb) as ExpressFareRmb,
        sum(ProfitRmb) as ProfitRmb

      from #DevGrossProfit
      WHERE ISNULL(CreateDate, '') <=CONVERT(VARCHAR(10),DATEADD(dd, -361, @EndDate),121)
      GROUP BY

        CreateDate,
        SalerName
      --SalerName2
    ) ss
    LEFT JOIN #devOfflinefee dof ON dof.salername = ss.SalerName AND dof.TimeGroup='12月以上'
    LEFT JOIN #dev1OperateFee dpf ON dpf.salername = ss.SalerName AND dpf.TimeGroup='12月以上'

  group by
    ss.SalerName,isnull(dof.Amount,0),isnull(dpf.Amount,0)

  --select * FROM #AboveTwe

  select
    '归属1人表' as tableType,
    t0.timegroup as timegroupZero,
    CASE WHEN t0.salername =''
      THEN '无人'
    ELSE t0.salername
    END
      as salernameZero,
    t0.salemoneyrmbus as salemoneyrmbusZero,
    t0.salemoneyrmbzn as salemoneyrmbznZero,
    t0.costmoneyrmb as costmoneyrmbZero,
    t0.ppebayus as ppebayusZero,
    t0.ppebayzn as ppebayznZero,
    t0.inpackagefeermb as inpackagefeermbZero,
    t0.expressfarermb as expressfarermbZero,
    t0.devofflinefee as devofflinefeeZero,
    t0.devOpeFee as devOpeFeeZero,
    t0.netprofit as netprofitZero,
    t0.netrate as netrateZero,
    t6.timegroup as timegroupSix,
    t6.salemoneyrmbus as salemoneyrmbusSix,
    t6.salemoneyrmbzn as salemoneyrmbznSix,
    t6.costmoneyrmb as costmoneyrmbSix,
    t6.ppebayus as ppebayusSix,
    t6.ppebayzn as ppebayznSix,
    t6.inpackagefeermb as inpackagefeermbSix,
    t6.expressfarermb as expressfarermbSix,
    t6.devofflinefee as devofflinefeeSix,
    t6.devOpeFee as devOpeFeeSix,
    t6.netprofit as netprofitSix,
    t6.netrate as netrateSix,
    t12.timegroup as timegroupTwe,
    t12.salemoneyrmbus as salemoneyrmbusTwe,
    t12.salemoneyrmbzn as salemoneyrmbznTwe,
    t12.costmoneyrmb as costmoneyrmbTwe,
    t12.ppebayus as ppebayusTwe,
    t12.ppebayzn as ppebayznTwe,
    t12.inpackagefeermb as inpackagefeermbTwe,
    t12.expressfarermb as expressfarermbTwe,
    t12.devofflinefee as devofflinefeeTwe,
    t12.devOpeFee as devOpeFeeTwe,
    t12.netprofit as netprofitTwe,
    t12.netrate as netrateTwe,
    (isnull(t0.salemoneyrmbzn,0) + isnull(t6.salemoneyrmbzn,0) + isnull(t12.salemoneyrmbzn,0)) as salemoneyrmbtotal,
    (isnull(t0.netprofit,0) + isnull(t6.netprofit,0) + isnull(t12.netprofit,0)) as netprofittotal,
    case when isnull(t0.salemoneyrmbzn,0) + isnull(t6.salemoneyrmbzn,0) + isnull(t12.salemoneyrmbzn,0)=0
      then 0
    else
      cast((isnull(t0.netprofit,0) + isnull(t6.netprofit,0) + isnull(t12.netprofit,0))/(isnull(t0.salemoneyrmbzn,0) + isnull(t6.salemoneyrmbzn,0) + isnull(t12.salemoneyrmbzn,0))*100 as DECIMAL(20,2))
    end
      as netratetotal

  INTO #dev1Alldata
  from  #ZeroToSixM t0
    left join #SixToTweM t6 on t0.salername=t6.salername
    LEFT JOIN #AboveTwe t12 on t12.salername=t0.salername
  where  t0.salername LIKE '%'+@salername+'%' OR  t0.salername IN (SELECT salername FROM #tbSalerName)

  --select * from #dev1Alldata

  --业绩归属人2的清仓表
  select
    dev2.salername2,dev2.timegroup,sum(dev2.amount)as Amount
  INTO #dev2Offlinefee
  from
    (SELECT
       SalerName2,
       timegroup,
       sum(amount) as amount,
       devClearnTime
     FROM Y_devOfflineClearn
     WHERE devClearnTime  BETWEEN @BeginDate  AND @EndDate
     group by salername2,timegroup,devClearnTime) dev2
  group  by dev2.salername2,dev2.timegroup

  --业绩归属人2的 运营杂费
  select dev2.salername2,dev2.timegroup,sum(dev2.amount)as Amount
  INTO #dev2OperateFee
  from
    (SELECT
       SalerName2,
       timegroup,
       sum(amount) as amount,
       devOperateTime
     FROM Y_devOperateFee
     WHERE devOperateTime  BETWEEN @BeginDate  AND @EndDate
     group by salername2,timegroup,devOperateTime) dev2
  group  by dev2.salername2,dev2.timegroup

  --0-6个月的产品 归属人2
  SELECT
      '0-6月' as 'TimeGroup' ,
    ss.salername2,
    --ss.salername22,
      cast(SUM(SaleMoneyRmb) / @ExchangeRate as DECIMAL(10,2)) as SaleMoneyRmbUS,              	 	--销售额$
      cast((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate  as DECIMAL(10,2)) as SaleMoneyRmbZn ,  	--销售额￥
      cast(SUM(CostMoneyRmb) as DECIMAL(10,2)) as CostMoneyRmb,	    															--商品成本
      cast(SUM(PPebay) / @ExchangeRate as DECIMAL(10,2)) as PPebayUS,                           --手续费$
      cast((SUM(PPebay) / @ExchangeRate) * @devRate as DECIMAL(10,2)) as PPebayZn,              --手续费￥
      cast(SUM(InPackageFeeRmb) as DECIMAL(10,2)) as InPackageFeeRmb,                           --包装成本
      cast(SUM(ExpressFareRmb) as DECIMAL(10,2)) as ExpressFareRmb                              --运费成本
    ,cast(isnull(dof.Amount,0) as DECIMAL(10,2)) as 'devOfflineFee'						--死库费用
    ,cast(isnull(dpf.Amount,0) as DECIMAL(10,2)) as 'devOpeFee'																--运营杂费
    ,cast(
          (SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
          -SUM(CostMoneyRmb)
          -(SUM(PPebay) / @ExchangeRate) * @devRate
          -SUM(InPackageFeeRmb)
          -SUM(ExpressFareRmb)
          -isnull(dof.Amount,0)
          -isnull(dpf.Amount,0)

          as DECIMAL(10,2)) as NetProfit                                        --毛利润
    , cast( 100*((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
                 -SUM(CostMoneyRmb)
                 -(SUM(PPebay) / @ExchangeRate) * @devRate
                 -SUM(InPackageFeeRmb)
                 -SUM(ExpressFareRmb)
                 -isnull(dof.Amount,0)-isnull(dpf.Amount,0))/((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate) as DECIMAL(10,2)) as netRate
  --毛利率
  INTO #ZeroToSixM2
  from
    (
      select
        CreateDate,
        salername2,
        --salername22,
        sum(CostMoneyRmb) as	CostMoneyRmb,
        sum(SaleMoneyRmb) as SaleMoneyRmb,
        sum(CostMoneyRmbSaler) as CostMoneyRmbSaler,
        sum(PaypalFeeRmb+eBayFeeRmb)  as PPebay ,
        sum(InPackageFeeRmb) as InPackageFeeRmb,
        sum(ExpressFareRmb) as ExpressFareRmb,
        sum(ProfitRmb) as ProfitRmb

      from #DevGrossProfit
      WHERE ISNULL(CreateDate, '') BETWEEN CONVERT(VARCHAR(10),DATEADD(dd, -180, @EndDate),121) AND @EndDate
      GROUP BY
        CreateDate,
        salername2
      --salername22
    ) ss
    LEFT JOIN #dev2Offlinefee dof ON dof.salername2 = ss.salername2 AND  dof.TimeGroup='0-6月'
    LEFT JOIN #dev2OperateFee dpf ON dpf.salername2 = ss.SalerName2 AND  dpf.TimeGroup='0-6月'

  group by
    ss.salername2,isnull(dof.Amount,0),isnull(dpf.Amount,0)

  --SELECT * from #ZeroToSixM2

  --6-12月 归属人2
  SELECT
      '6-12月' as 'TimeGroup' ,
    ss.salername2,
    --ss.salername22,
      cast(SUM(SaleMoneyRmb) / @ExchangeRate as DECIMAL(10,2)) as SaleMoneyRmbUS,              	 	--销售额$
      cast((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate  as DECIMAL(10,2)) as SaleMoneyRmbZn ,  	--销售额￥
      cast(SUM(CostMoneyRmb) as DECIMAL(10,2)) as CostMoneyRmb,	    															--商品成本
      cast(SUM(PPebay) / @ExchangeRate as DECIMAL(10,2)) as PPebayUS,                           --手续费$
      cast((SUM(PPebay) / @ExchangeRate) * @devRate as DECIMAL(10,2)) as PPebayZn,              --手续费￥
      cast(SUM(InPackageFeeRmb) as DECIMAL(10,2)) as InPackageFeeRmb,                           --包装成本
      cast(SUM(ExpressFareRmb) as DECIMAL(10,2)) as ExpressFareRmb                              --运费成本
    ,cast(isnull(dof.Amount,0) as DECIMAL(10,2)) as 'devOfflineFee'						--死库费用
    ,cast(isnull(dpf.Amount,0) as DECIMAL(10,2)) as 'devOpeFee'																--运营杂费
    ,cast(
          (SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
          -SUM(CostMoneyRmb)
          -(SUM(PPebay) / @ExchangeRate) * @devRate
          -SUM(InPackageFeeRmb)
          -SUM(ExpressFareRmb)
          -isnull(dof.Amount,0)
          -isnull(dpf.Amount,0)
          as DECIMAL(10,2)) as NetProfit                                        --毛利润
    , cast( 100*((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
                 -SUM(CostMoneyRmb)
                 -(SUM(PPebay) / @ExchangeRate) * @devRate
                 -SUM(InPackageFeeRmb)
                 -SUM(ExpressFareRmb)
                 -isnull(dof.Amount,0)-isnull(dpf.Amount,0))/((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate) as DECIMAL(10,2)) as netRate
  --毛利率
  INTO #SixToTweM2
  from
    (
      select
        CreateDate,
        salername2,

        sum(CostMoneyRmb) as	CostMoneyRmb,
        sum(SaleMoneyRmb) as SaleMoneyRmb,
        sum(CostMoneyRmbSaler) as CostMoneyRmbSaler,
        sum(PaypalFeeRmb+eBayFeeRmb)  as PPebay ,
        sum(InPackageFeeRmb) as InPackageFeeRmb,
        sum(ExpressFareRmb) as ExpressFareRmb,
        sum(ProfitRmb) as ProfitRmb

      from #DevGrossProfit
      WHERE ISNULL(CreateDate, '') BETWEEN CONVERT(VARCHAR(10),DATEADD(dd, -360, @EndDate),121) AND CONVERT(VARCHAR(10),DATEADD(dd, -180, @EndDate),121)
      GROUP BY
        CreateDate,
        salername2
      --salername22
    ) ss
    LEFT JOIN #dev2Offlinefee dof ON dof.salername2 = ss.salername2 AND dof.TimeGroup='6-12月'
    LEFT JOIN #dev2OperateFee dpf ON dpf.salername2 = ss.SalerName2 AND dpf.TimeGroup='6-12月'
  group by
    ss.salername2,isnull(dof.Amount,0),isnull(dpf.Amount,0)

  --select * FROM #SixToTweM2

  --12月以上 归属人2
  SELECT
      '12月以上' as 'TimeGroup' ,
    ss.salername2,
    --ss.salername22,
      cast(SUM(SaleMoneyRmb) / @ExchangeRate as DECIMAL(10,2)) as SaleMoneyRmbUS,              	 	--销售额$
      cast((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate  as DECIMAL(10,2)) as SaleMoneyRmbZn ,  	--销售额￥
      cast(SUM(CostMoneyRmb) as DECIMAL(10,2)) as CostMoneyRmb,	    															--商品成本
      cast(SUM(PPebay) / @ExchangeRate as DECIMAL(10,2)) as PPebayUS,                           --手续费$
      cast((SUM(PPebay) / @ExchangeRate) * @devRate as DECIMAL(10,2)) as PPebayZn,              --手续费￥
      cast(SUM(InPackageFeeRmb) as DECIMAL(10,2)) as InPackageFeeRmb,                           --包装成本
      cast(SUM(ExpressFareRmb) as DECIMAL(10,2)) as ExpressFareRmb                              --运费成本
    ,cast(isnull(dof.Amount,0) as DECIMAL(10,2)) as 'devOfflineFee'						--死库费用
    ,cast(isnull(dpf.Amount,0) as DECIMAL(10,2)) as 'devOpeFee'																--运营杂费
    ,cast(
          (SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
          -SUM(CostMoneyRmb)
          -(SUM(PPebay) / @ExchangeRate) * @devRate
          -SUM(InPackageFeeRmb)
          -SUM(ExpressFareRmb)
          -isnull(dof.Amount,0)
          -isnull(dpf.Amount,0)

          as DECIMAL(10,2)) as NetProfit                                        --毛利润
    , cast( 100*((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate
                 -SUM(CostMoneyRmb)
                 -(SUM(PPebay) / @ExchangeRate) * @devRate
                 -SUM(InPackageFeeRmb)
                 -SUM(ExpressFareRmb)
                 -isnull(dof.Amount,0)-isnull(dpf.Amount,0))/((SUM(SaleMoneyRmb) / @ExchangeRate)* @devRate) as DECIMAL(10,2)) as netRate
  --毛利率
  INTO #AboveTwe2
  from
    (
      select
        CreateDate,
        salername2,
        --salername22,
        sum(CostMoneyRmb) as	CostMoneyRmb,
        sum(SaleMoneyRmb) as SaleMoneyRmb,
        sum(CostMoneyRmbSaler) as CostMoneyRmbSaler,
        sum(PaypalFeeRmb+eBayFeeRmb)  as PPebay ,
        sum(InPackageFeeRmb) as InPackageFeeRmb,
        sum(ExpressFareRmb) as ExpressFareRmb,
        sum(ProfitRmb) as ProfitRmb

      from #DevGrossProfit
      WHERE ISNULL(CreateDate, '') <=CONVERT(VARCHAR(10),DATEADD(dd, -361, @EndDate),121)
      GROUP BY
        CreateDate,
        salername2
      --salername22
    ) ss
    LEFT JOIN #dev2Offlinefee dof ON dof.salername2 = ss.salername2 AND  dof.TimeGroup='12月以上'
    LEFT JOIN #dev2OperateFee dpf ON dpf.salername2 = ss.SalerName2 AND dpf.TimeGroup='12月以上'

  group by
    ss.salername2,isnull(dof.Amount,0),isnull(dpf.Amount,0)

  --select * from  #AboveTwe2

  select
    '归属2人表' as tableType,
    t0.timegroup as timegroupZero,
    --t0.salername2 as salername2Zero,
    CASE WHEN t12.salername2 =''
      THEN '无人'
    ELSE t12.salername2
    END
      as salername2Zero,
    t0.salemoneyrmbus as salemoneyrmbusZero,
    t0.salemoneyrmbzn as salemoneyrmbznZero,
    t0.costmoneyrmb as costmoneyrmbZero,
    t0.ppebayus as ppebayusZero,
    t0.ppebayzn as ppebayznZero,
    t0.inpackagefeermb as inpackagefeermbZero,
    t0.expressfarermb as expressfarermbZero,
    t0.devofflinefee as devofflinefeeZero,
    t0.devOpeFee as devOpeFeeZero,
    t0.netprofit as netprofitZero,
    t0.netrate as netrateZero,
    t6.timegroup as timegroupSix,
    t6.salemoneyrmbus as salemoneyrmbusSix,
    t6.salemoneyrmbzn as salemoneyrmbznSix,
    t6.costmoneyrmb as costmoneyrmbSix,
    t6.ppebayus as ppebayusSix,
    t6.ppebayzn as ppebayznSix,
    t6.inpackagefeermb as inpackagefeermbSix,
    t6.expressfarermb as expressfarermbSix,
    t6.devofflinefee as devofflinefeeSix,
    t6.devOpeFee as devOpeFeeSix,
    t6.netprofit as netprofitSix,
    t6.netrate as netrateSix,
    t12.timegroup as timegroupTwe,
    t12.salemoneyrmbus as salemoneyrmbusTwe,
    t12.salemoneyrmbzn as salemoneyrmbznTwe,
    t12.costmoneyrmb as costmoneyrmbTwe,
    t12.ppebayus as ppebayusTwe,
    t12.ppebayzn as ppebayznTwe,
    t12.inpackagefeermb as inpackagefeermbTwe,
    t12.expressfarermb as expressfarermbTwe,
    t12.devofflinefee as devofflinefeeTwe,
    t12.devOpeFee as devOpeFeeTwe,
    t12.netprofit as netprofitTwe,
    t12.netrate as netrateTwe,
    (isnull(t0.salemoneyrmbzn,0) + isnull(t6.salemoneyrmbzn,0) + isnull(t12.salemoneyrmbzn,0)) as salemoneyrmbtotal,
    (isnull(t0.netprofit,0) + isnull(t6.netprofit,0) + isnull(t12.netprofit,0)) as netprofittotal,
    case when isnull(t0.salemoneyrmbzn,0) + isnull(t6.salemoneyrmbzn,0) + isnull(t12.salemoneyrmbzn,0)=0
      then 0
    else
      cast((isnull(t0.netprofit,0) + isnull(t6.netprofit,0) + isnull(t12.netprofit,0))/(isnull(t0.salemoneyrmbzn,0) + isnull(t6.salemoneyrmbzn,0) + isnull(t12.salemoneyrmbzn,0))*100 as DECIMAL(20,2))
    end
      as netratetotal

  INTO #dev2Alldata
  from  #AboveTwe2 t12
    LEFT JOIN #SixToTweM2 t6 on t12.salername2=t6.salername2
    LEFT JOIN   #ZeroToSixM2 t0 on t12.salername2=t0.salername2
  where  t12.salername2 LIKE '%'+@salername+'%' OR  t12.salername2 IN (SELECT salername FROM #tbSalerName)


  SELECT * from
    (SELECT * from #dev1Alldata

     UNION
     SELECT * from #dev2Alldata

    ) haha
  order by tableType asc, salernameZero DESC,
    salemoneyrmbtotal asc


  DROP TABLE #devOfflinefee
  DROP TABLE #dev2Offlinefee
  drop table #dev1OperateFee
  drop table #dev2OperateFee
  drop table #ZeroToSixM
  drop TABLE #SixToTweM
  drop TABLE #AboveTwe
  drop table #dev1AllData
  drop table #ZeroToSixM2
  drop TABLE #SixToTweM2
  drop TABLE #AboveTwe2
  drop table #dev2AllData



end
