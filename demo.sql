select convert(varchar(10),tpt.refund_time,121) as refund_time,tpt.total_value,pt.shiptocountrycode  from  #MergedTable  as tpt LEFT JOIN P_Trade as pt  on pt.ack=tpt.ack
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
 where pt.nid is not null and tpt.isMerged='非合并订单'
UNION

select convert(varchar(10),tpt.refund_time,121) as refund_time,tpt.total_value,pt.shiptocountrycode  from  #MergedTable  as tpt LEFT JOIN P_Tradeun as pt  on pt.ack=tpt.ack
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
where pt.nid is not null and tpt.isMerged='非合并订单'
UNION

select convert(varchar(10),tpt.refund_time,121) as refund_time,tpt.total_value,pt.shiptocountrycode  from  #MergedTable  as tpt LEFT JOIN P_Trade_his as pt  on pt.ack=tpt.ack
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
where pt.nid is not null and tpt.isMerged='非合并订单'

UNION
select tpt.ack,convert(varchar(10),pt.closingdate,121) as closingdate,  l.name  from  #MergedTable  as tpt LEFT JOIN P_Tradeun_his as pt  on pt.ack=tpt.ack
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
where pt.nid is not null and tpt.isMerged='非合并订单'
UNION

select tpt.ack,convert(varchar(10),pt.closingdate,121) as closingdate,  l.name from  #MergedTable  as tpt LEFT JOIN p_trade_b as pb on pb.ack=tpt.ack LEFT JOIN P_Trade as pt  on pb.mergebillid=pt.nid
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
where pt.nid is not null and tpt.isMerged='合并订单'
UNION

select convert(varchar(10),tpt.refund_time,121) as refund_time,tpt.total_value,pt.shiptocountrycode  from  #MergedTable as tpt LEFT JOIN p_trade_b as pb on pb.ack=tpt.ack LEFT JOIN P_Tradeun as pt  on pb.mergebillid=pt.nid
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
 where pt.nid is not null and tpt.isMerged='合并订单'
UNION

select convert(varchar(10),tpt.refund_time,121) as refund_time,tpt.total_value,pt.shiptocountrycode  from  #MergedTable  as tpt lEFT JOIN p_trade_b as pb on pb.ack=tpt.ack LEFT JOIN P_Trade_his as  pt  on pb.mergebillid=pt.nid
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
 where pt.nid is not null and tpt.isMerged='合并订单'

UNION

select tpt.ack,convert(varchar(10),pt.closingdate,121) as closingdate,  l.name  from  #MergedTable  as tpt lEFT JOIN p_trade_b as pb on pb.ack=tpt.ack LEFT JOIN P_Tradeun_his as  pt  on pb.mergebillid=pt.nid
lEFT JOIN B_LogisticWay as  l on pt.logicswaynid=l.nid
 where pt.nid is not null and tpt.isMerged='合并订单'