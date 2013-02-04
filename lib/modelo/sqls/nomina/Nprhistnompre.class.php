<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistnompre extends baseClases
{

    function sql($especial,$tipnomesp,$tipnomdes,$condes,$conhas,$fechades,$fechahas)
    {
        if ($especial == 'S')
        {
            $especial = " a.especial = 'S' AND
                                     A.CODNOMESP = '$tipnomesp' AND ";
        }
        else
        {
            if ($especial == 'N')
                $especial = " a.especial = 'N' AND";
        }
        
        /*and
         a.fecnomdes>=to_date('".$this->fechades."','dd/mm/yyyy') and
         a.fecnom<=to_date('".$this->fechahas."','dd/mm/yyyy') and*/
        $sql="SELECT distinct A.CODPRE,b.nompre,A.ASIGNA as ASIGNA,A.DEDUCI as DEDUCI, A.APORTE as APORTE,a.codtipgas,a.destipgas FROM
		        (
		        SELECT a.CODCAT||'-'||C.CODPAR as CODPRE,
		        a.codnom as codnom,
		        SUM(case when C.OPECON = 'A' then A.MONTO else 0 end) as ASIGNA,
		        SUM(case when C.OPECON = 'D' then A.MONTO else 0 end ) as DEDUCI,
		        SUM(case when C.OPECON = 'P' then A.MONTO else 0 end) as APORTE,
		        a.codtipgas,d.destipgas
		        FROM NPHISCON A,NPDEFCPT C,nptipgas d
		        WHERE
		        A.CODNOM = '$tipnomdes' AND
		        A.CODCON >= '$condes' AND
		        A.CODCON <= '$conhas' AND   A.CODCON<>'006' and ".$especial."
                a.fecnomdes >= to_date('$fechades','dd/mm/yyyy') and
				a.fecnom <= to_date('$fechahas','dd/mm/yyyy') and
		        a.CODTIPGAS=D.CODTIPGAS AND
		        C.CODCON=A.CODCON AND
		        A.MONTO>0 AND
		        A.CODCON NOT IN (SELECT CODCON FROM npconceptoscategoria) and
                A.CODCON NOT IN (SELECT CODCON FROM npasiparcon)
		        GROUP BY  (a.CODCAT||'-'||C.CODPAR),a.codnom,a.codtipgas,d.destipgas
		        UNION
		        SELECT (D.CODCAT||'-'||C.CODPAR) as CODPRE,
		        a.codnom as codnom,
		        SUM(case when C.OPECON='A' then A.MONTO else 0 end) as ASIGNA,
		        SUM(case when C.OPECON='D' then A.MONTO else 0 end) as DEDUCI,
		        SUM(case when C.OPECON='P' then A.MONTO else 0 end) as APORTE,
		        a.codtipgas,e.destipgas
                FROM NPHISCON A,NPDEFCPT C, npconceptoscategoria D, nptipgas e
                WHERE
                a.codcon=d.codcon and
		        A.CODNOM = '$tipnomdes' AND
		        A.CODCON >= '$condes' AND
		        A.CODCON <= '$conhas' AND   A.CODCON<>'006' and  ".$especial."
                a.fecnomdes>=to_date('$fechades','dd/mm/yyyy') and
			    a.fecnom<=to_date('$fechahas','dd/mm/yyyy') and
		        a.CODTIPGAS=E.CODTIPGAS AND
		        C.CODCON=A.CODCON AND
		        A.MONTO>0
		        GROUP BY (D.CODCAT||'-'||C.CODPAR),a.codnom,a.codtipgas,e.destipgas
				UNION
				SELECT (a.CODCAT||'-'||D.CODPar) as CODPRE,
				a.codnom as codnom,
				SUM(case when C.OPECON='A' then A.MONTO else 0 end) as ASIGNA,
				SUM(case when C.OPECON='D' then A.MONTO else 0 end) as DEDUCI,
				SUM(case when C.OPECON='P' then A.MONTO else 0 end) as APORTE,
				a.codtipgas,e.destipgas
				FROM NPHISCON A,NPDEFCPT C, npasiparcon D, nptipgas E
				WHERE
				a.codnom=d.codnom and
				a.codcon=d.codcon and
				a.codcar=d.codcar and   A.CODCON<>trim('006') and
				A.CODNOM = '$tipnomdes' AND  ".$especial."
				a.fecnomdes>=to_date('$fechades','dd/mm/yyyy') and
				a.fecnom<=to_date('$fechahas','dd/mm/yyyy') and
				a.CODTIPGAS=E.CODTIPGAS AND
				C.CODCON=A.CODCON AND
				A.MONTO>0
				GROUP BY (a.CODCAT||'-'||D.CODPar),a.codnom,a.codtipgas,e.destipgas
		        ) A left outer join  CPDEFTIT B on (A.CODPRE=B.CODPRE)  left outer join CONTABB C  on (B.CODCTA=C.CODCTA)
		         where
		         (a.asigna>0 OR A.APORTE>0) AND
		         a.codpre is not null
		         order by a.codtipgas,a.codpre";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	
    function sqls($tipnom)
    {
            $sql = "select upper(nomnom) as nombre from NPASICAREMP where codnom='$tipnom'";
        return $this->select($sql);
    }
	
    function sql5($refcat)
    {
        $sql = "SELECT NOMPRE as nombre FROM CPDEFTIT
				WHERE CODPRE = '$refcat'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	
}
?>
