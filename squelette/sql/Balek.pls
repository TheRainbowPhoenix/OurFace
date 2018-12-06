CREATE OR REPLACE FUNCTION testfiltre(debut INTEGER, fin INTEGER)
RETURNS TABLE(empno INTEGER, mgr INTEGER) AS $$
DECLARE
	ret RECORD;
BEGIN

	for ret in (select * from emp order by empno desc limit fin-debut+1 offset debut-1)
	LOOP
		empno:=ret.empno;
		mgr:=ret.mgr;
		RETURN NEXT;
	END LOOP;

END; $$ LANGUAGE plpgsql;
