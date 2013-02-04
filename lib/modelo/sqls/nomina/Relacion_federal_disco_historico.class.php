<?php
require_once("../../lib/modelo/baseClases.class.php");
class Federal extends BaseClases {

	public function sqlp($coddes,$codhas,$codespdes,$codesphas,$banco,$especial,$fechamax)
    {



		if ($especial == 'S')
		{
					$sql="select cedemp, nomemp, cuenta_banco, sum(monto) as monto  from (
		(SELECT DISTINCT A.CODEMP AS CODEMP, cast(A.codemp as int) AS CODEMPORD,SUM (a.monto) AS monto,
					B.CEDEMP as cedemp, B.NOMEMP as nomemp, B.NUMCUE AS cuenta_banco
					FROM NPHISCON A left OUTER JOIN NPHOJINT B ON (A.CODEMP = B.CODEMP), NPBANCOS C,  npdefcpt d
					WHERE A.ESPECIAL = 'S' and d.opecon = 'A'
					AND B.CODBAN = C.CODBAN
					AND A.CODNOM>=('".$coddes."')
					AND A.CODNOM<=('".$codhas."')
					AND A.CODNOMESP>=('".$codespdes."')
					AND A.CODNOMESP<=('".$codesphas."')
					AND C.CODBAN = '".$banco."'
					AND (B.STAEMP IN (SELECT CODSITEMP FROM NPSITEMP WHERE CALNOM='S') or b.fecret<=a.fecnom)
					AND a.monto>0 and a.codcon=d.codcon
					AND RTRIM(COALESCE(B.NUMCUE,' '))<>'' and  a.fecnom=to_date('$fechamax','DD/MM/YYYY')
					GROUP BY CODEMPORD, A.CODEMP, B.CEDEMP, B.NOMEMP,B.NUMCUE
					order by CODEMPORD)
		union

		(SELECT DISTINCT A.CODEMP AS CODEMP, cast(A.codemp as int) AS CODEMPORD,(SUM (a.monto))*-1 AS monto,
					B.CEDEMP as cedemp, B.NOMEMP as nomemp, B.NUMCUE AS cuenta_banco
					FROM NPHISCON A left OUTER JOIN NPHOJINT B ON (A.CODEMP = B.CODEMP), NPBANCOS C,  npdefcpt d
					WHERE A.ESPECIAL = 'S' and d.opecon = 'D'
					AND B.CODBAN = C.CODBAN
					AND A.CODNOM>=('".$coddes."')
					AND A.CODNOM<=('".$codhas."')
					AND A.CODNOMESP>=('".$codespdes."')
					AND A.CODNOMESP<=('".$codesphas."')
					AND C.CODBAN = '".$banco."'
					AND (B.STAEMP IN (SELECT CODSITEMP FROM NPSITEMP WHERE CALNOM='S') or b.fecret<=a.fecnom)
					AND a.monto>0 and a.codcon=d.codcon
					AND RTRIM(COALESCE(B.NUMCUE,' '))<>'' and  a.fecnom=to_date('$fechamax','DD/MM/YYYY')
					GROUP BY CODEMPORD, A.CODEMP, B.CEDEMP, B.NOMEMP,B.NUMCUE
					order by CODEMPORD)) a group by cedemp, nomemp, cuenta_banco, codempord
					order by codempord";

		}

		else
		{
			$sql= "select distinct a.codemp, a.codcar,cast(a.codemp as int) AS cedemp,
					(sum(CASE WHEN d.opecon='A' THEN coalesce(a.monto,0) ELSE 0 END) - sum(CASE WHEN d.opecon='D' THEN coalesce(a.monto,0) ELSE 0 END)) AS monto,
					c.nomemp, c.numcue as cuenta_banco
					from
					NPHISCON a, nphojint c,  npdefcpt d
					where
                   	a.codnom >=trim('".$coddes."') and a.codnom <= trim('".$codhas."')  and c.codban = '".$banco."' and
					c.codemp=a.codemp and a.codcon=d.codcon and
					A.ESPECIAL = '".$especial."'  AND (C.STAEMP IN (SELECT CODSITEMP FROM NPSITEMP WHERE CALNOM='S') or c.fecret<=a.fecnom) and  a.fecnom=to_date('$fechamax','DD/MM/YYYY')
					group by  a.codemp,a.codcar, c.nomemp, c.numcue order by a.codcar,cedemp";
//print '<pre>'; print $sql;
		}

		//H::PrintR($sql);exit;
	    return $this->select($sql);

    }


    public function nomina($coddes,$codhas,$codespdes,$codesphas,$banco,$especial,$fechamax)
    {

	if ($especial == 'S')
		{
			$sql= "SELECT sum (a.monto) as nomina from (
		(SELECT DISTINCT A.CODEMP AS CODEMP, cast(A.codemp as int) AS CODEMPORD,SUM (a.monto) AS monto,
					B.CEDEMP as cedemp, B.NOMEMP as nomemp, B.NUMCUE AS cuenta_banco
					FROM NPHISCON A left OUTER JOIN NPHOJINT B ON (A.CODEMP = B.CODEMP), NPBANCOS C,  npdefcpt d
					WHERE A.ESPECIAL = 'S' and d.opecon = 'A'
					AND B.CODBAN = C.CODBAN
					AND A.CODNOM>=('".$coddes."')
					AND A.CODNOM<=('".$codhas."')
					AND A.CODNOMESP>=('".$codespdes."')
					AND A.CODNOMESP<=('".$codesphas."')
					AND C.CODBAN = '".$banco."'
					AND B.STAEMP IN (SELECT CODSITEMP FROM NPSITEMP WHERE CALNOM='S')
					AND a.monto>0 and a.codcon=d.codcon
					AND RTRIM(COALESCE(B.NUMCUE,' '))<>'' and  a.fecnom=to_date('$fechamax','DD/MM/YYYY')
					GROUP BY CODEMPORD, A.CODEMP, B.CEDEMP, B.NOMEMP,B.NUMCUE
					order by CODEMPORD)
		union

		(SELECT DISTINCT A.CODEMP AS CODEMP, cast(A.codemp as int) AS CODEMPORD,(SUM (a.monto))*-1 AS monto,
					B.CEDEMP as cedemp, B.NOMEMP as nomemp, B.NUMCUE AS cuenta_banco
					FROM NPHISCON A left OUTER JOIN NPHOJINT B ON (A.CODEMP = B.CODEMP), NPBANCOS C,  npdefcpt d
					WHERE A.ESPECIAL = 'S' and d.opecon = 'D'
					AND B.CODBAN = C.CODBAN
					AND A.CODNOM>=('".$coddes."')
					AND A.CODNOM<=('".$codhas."')
					AND A.CODNOMESP>=('".$codespdes."')
					AND A.CODNOMESP<=('".$codesphas."')
					AND C.CODBAN = '".$banco."'
					AND B.STAEMP IN (SELECT CODSITEMP FROM NPSITEMP WHERE CALNOM='S')
					AND a.monto>0 and a.codcon=d.codcon
					AND RTRIM(COALESCE(B.NUMCUE,' '))<>'' and  a.fecnom=to_date('$fechamax','DD/MM/YYYY')
					GROUP BY CODEMPORD, A.CODEMP, B.CEDEMP, B.NOMEMP,B.NUMCUE
					order by CODEMPORD)) a ";

		}
		else
		{
			$sql= "SELECT sum (a.monto) as nomina from (select distinct a.codemp, a.codcar,cast(a.codemp as int) AS cedemp,
					(sum(CASE WHEN d.opecon='A' THEN coalesce(a.monto,0) ELSE 0 END) - sum(CASE WHEN d.opecon='D' THEN coalesce(a.monto,0) ELSE 0 END)) AS monto,
					c.nomemp, c.numcue as cuenta_banco
					from
					NPHISCON a, nphojint c,  npdefcpt d
					where
                   	a.codnom >=trim('".$coddes."') and a.codnom <= trim('".$codhas."')  and c.codban = '".$banco."' and
					c.codemp=a.codemp and a.codcon=d.codcon and
					A.ESPECIAL = '".$especial."'  AND C.STAEMP IN (SELECT CODSITEMP FROM NPSITEMP WHERE CALNOM='S') and  a.fecnom=to_date('$fechamax','DD/MM/YYYY')
					group by  a.codemp,a.codcar, c.nomemp, c.numcue order by a.codcar,cedemp) a ";
		}

	//	H::PrintR($sql);exit;
	    return $this->select($sql);

    }
}
?>