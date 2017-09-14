CREATE TABLE [dbo].[menu] (
[id] int NOT NULL primary key IDENTITY(1,1) ,
[name] varchar(128) NULL ,
[parent] int NULL ,
[route] varchar(256) NULL ,
[order] int NULL ,
[data] varchar(MAX) NULL
)


CREATE TABLE [dbo].[auth_assignment] (
[item_name] varchar(64) NOT NULL ,
[user_id] varchar(64) NOT NULL ,
[created_at] int NULL
)


CREATE TABLE [dbo].[auth_item] (
[name] varchar(64) NOT NULL ,
[type] smallint NOT NULL ,
[description] text NULL ,
[rule_name] varchar(64) NULL ,
[data] varchar(MAX) NULL ,
[created_at] int NULL ,
[updated_at] int NULL
)


CREATE TABLE [dbo].[auth_item_child] (
[parent] varchar(64) NOT NULL ,
[child] varchar(64) NOT NULL
)


CREATE TABLE [dbo].[auth_rule] (
[name] varchar(64) NOT NULL ,
[data] varchar(MAX) NULL ,
[created_at] int NULL ,
[updated_at] int NULL
)