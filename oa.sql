-- 建产品表

Date: 2017-09-14 15:27:03
*/


-- ----------------------------
-- Table structure for oa_goods
-- ----------------------------
DROP TABLE [dbo].[oa_goods]
GO
CREATE TABLE [dbo].[oa_goods] (
[nid] int NOT NULL IDENTITY(1,1) ,
[cate] varchar(50) NULL ,
[devNum] varchar(80) NULL ,
[origin] varchar(300) NULL ,
[hopeProfit] decimal(6,2) NULL ,
[develpoer] varchar(10) NULL ,
[introducer] varchar(10) NULL ,
[devStatus] varchar(20) NULL ,
[checkStatus] varchar(20) NULL ,
[createDate] datetime NULL ,
[updateDate] datetime NULL
)


GO

-- ----------------------------
-- Indexes structure for table oa_goods
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table oa_goods
-- ----------------------------
ALTER TABLE [dbo].[oa_goods] ADD PRIMARY KEY ([nid])
GO



