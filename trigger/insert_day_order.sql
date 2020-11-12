IF(New.status=3)THEN

    IF(old.status=3) THEN
      UPDATE sp_daily_order SET total_line=(total_line-old.total_line)+New.total_line,total_discount
      =(total_discount-old.total_discount)+New.total_discount,total_tax=(total_tax-old.total_tax)+New.total_tax,total_ship=(total_ship-old.total_ship)+New.total_ship,total_amount=(total_amount-old.total_amount)+New.total_amount,total_refund=(total_refund-old.total_refund)+New.total_refund,total_cost=(total_cost-old.total_cost)+New.total_cost WHERE fk_AID=old.fk_AID AND date=old.created_at;
        END IF;
  IF(old.status<>3) THEN
      UPDATE sp_daily_order SET total_line=total_line+New.total_line,total_discount
       =total_discount+New.total_discount,total_tax=total_tax+New.total_tax,total_ship=total_ship+New.total_ship,total_amount=total_amount+New.total_amount,total_refund=total_refund+New.total_refund,total_cost=total_cost+New.total_cost WHERE fk_AID=old.fk_AID AND date=old.created_at;
    END IF;
ELSEIF(old.status=3) THEN
   UPDATE sp_daily_order SET total_line=total_line-New.total_line,total_discount
    =total_discount-New.total_discount,total_tax=total_tax-New.total_tax,total_ship=total_ship-New.total_ship,total_amount=total_amount-New.total_amount,total_refund=total_refund-New.total_refund,total_cost=total_cost-New.total_cost WHERE fk_AID=old.fk_AID AND date=old.created_at;
END IF