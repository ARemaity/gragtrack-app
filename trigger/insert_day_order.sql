CREATE TRIGGER `insert_day` AFTER
INSERT ON `
sp_order`
FOR
EACH
ROW
INSERT INTO sp_daily_summary
    (date, fk_AID, total_line, total_discount, total_tax, total_ship, total_amount, total_refund)
VALUES
    (New.created_at, New.fk_AID, New.total_line, New.total_discount, New.total_tax, New.total_ship, New.total_amount, New.total_refund)
ON DUPLICATE KEY
UPDATE total_line=total_line+New.total_line, total_discount=total_line+New.total_line, total_tax=total_line+New.total_line, total_ship=total_line+New.total_line, total_amount=total_line+New.total_line, total_refund=total_line+New.total_line; 