<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprprestliquidacion extends baseClases{
	
    function sql($cedula1, $cedula2)
    {
        $sql = "select
    						distinct a.codemp as cedula,b.nomemp as nombre,b.cedemp,
    						to_char(g.fechaingreso,'dd/mm/yyyy') as fecing, to_number(b.codemp,'99999999')   as ci,
    						to_char(b.fecret,'dd/mm/yyyy') as fecret,d.nomcar, to_char(i.fechacorte,'dd/mm/yyyy') as fechacorte,
    						e.desniv as ubicacion,f.nomemp as empresa,g.anoefectivo as ano,
    						g.mesefectivo as mes,g.diasefectivo as dia,g.anticipos,h.suecar, d.codnom, j.desret,d.codcar
    						from
    						npliquidacion_det a,nphojint b,npasicaremp d,npestorg e,empresa f,npliquidacion g,npcargos h, npliquidacion i, nptipret j
    						where
    						a.codemp=b.codemp and a.codemp=d.codemp and a.codemp = i.cedula and e.codniv=b.codniv and d.codcar=h.codcar
    						and f.codemp='001' and a.codemp=g.cedula and a.codemp>='$cedula1'
    						and a.codemp<='$cedula2' and b.codret=j.codret  and d.status='V'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function bcargo($var,$datocedula,$ultfec)
    {
        if ($var == 0)
        {
            $sql = "SELECT distinct CODCAR||'   '||NOMCAR as cargo,codcar  FROM NPASICAREMP
        				WHERE codemp= '$datocedula'";
        } else if ($var == 1)
        {
            $sql = "SELECT MAX(FECNOM) as ultfec FROM NPHISCON
        							WHERE codemp= '$datocedula'";
        } else if ($var == 2)
        {
            $sql = "SELECT DISTINCT(RTRIM(A.CODCAR))||'  '||B.NOMCAR AS cargo
        								FROM NPHISCON A, NPCARGOS B
        								WHERE A.CODEMP = '$datocedula' AND
        								A.FECNOM = to_date('$ultfec','yyyy-mm-dd') AND
        								A.CODCAR=B.CODCAR AND
        								A.CODCON NOT IN (SELECT CODCON FROM NPCONCEPTOSCATEGORIA)";
        }
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function bubicacion($var,$datocedula,$ultfec)
    {
        if ($var == 0)
        {
            $sql = "SELECT max(CODCAT||'   '||NOMCAT) as categoria
						 FROM NPASICAREMP WHERE codemp= '$datocedula'";
        } else if ($var == 1)
        {
        	$sql = "SELECT MAX(FECNOM) as ultfec FROM NPHISCON
							WHERE codemp= '$datocedula'";
        } else if ($var == 2)
        {
        	$sql = "SELECT DISTINCT max((RTRIM(A.CODCAT))||'   '||B.NOMCAT) AS categoria
								FROM NPHISCON A, NPCATPRE B
								WHERE A.CODEMP = '$datocedula' AND
								A.FECNOM = to_date('$ultfec','yyyy-mm-dd') AND
								A.CODCAT=B.CODCAT AND
								A.CODCON NOT IN (SELECT CODCON FROM NPCONCEPTOSCATEGORIA)";
        }
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function bsalario($var,$datocedula,$datocodnom,$datocodcar)
    {
        if ($var == 0)
        {
            $sql = "Select coalesce(SUM(MonAsi),0) as valor from NPSALINT
						 where CodEmp='$datocedula' and FECFINCON=  order by FECFINCON Desc";
        } else if ($var == 1)
        {
        	$sql = "Select coalesce(SUM(MonAsi),0) as valor from NPSALINT
						 where CodEmp='$datocedula' and FECFINCON=to_date('30/06/1997','dd/mm/yyyy')";
        }else if ($var == 2)
        {
        	$sql = "Select coalesce(SUM(a.monasi),0) as campo from npsalint A where
												 a.codemp='$datocedula' and
												to_char(fecinicon,'mm/yyyy')=to_char((select max(fecinicon ) from npsalint  where codemp='$datocedula' and monasi>0),'mm/yyyy')";
		}
		
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	
	function btotales($var,$datocedula)
    {
        if ($var == 0)
        {
            $sql = "SELECT coalesce(SUM(MONTO),0) as montoasi
						FROM NPLIQUIDACION_DET
						WHERE ASIDED='A' and
						codemp= '$datocedula'";
        } else if ($var == 1)
        {
            $sql = "SELECT coalesce(SUM(MONTO),0) as montoded
						FROM NPLIQUIDACION_DET
						WHERE ASIDED='D' and
						codemp= '$datocedula'";
        } else if ($var == 2)
        {
            $sql = "SELECT coalesce(SUM(MONTO),0) as montovac
						FROM NPVACLIQUIDACION
						where codemp= '$datocedula'";
        } else if ($var == 3)
        {
            $sql = "SELECT
							(ultsue/30) as saldiario, (montoinci/30) as convnecion
							FROM NPVACLIQUIDACION
							WHERE codemp= '$datocedula' and perini=(select max(perini) from npvacliquidacion)";
				//print"<pre> sql=".$sql;exit;
        }
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	function asi($datocedula)
    {
        $sql = "SELECT
							CODEMP as CODEEMPASI,
							CONCEPTO as CONCEPTOASI,
							MONTO as MONTOASI,dias
							FROM NPLIQUIDACION_DET
							WHERE ASIDED='A'
							AND codemp= '$datocedula'
							ORDER BY NUMREG";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	function ded($datocedula)
    {
        $sql = "SELECT
							CODEMP as CODEEMPDED,
							CONCEPTO as CONCEPTODED,
							MONTO as MONTODED
							FROM NPLIQUIDACION_DET
							WHERE codemp= '$datocedula' and ASIDED='D'
							ORDER BY NUMREG";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	function vac($datocedula)
    {
        $sql = "SELECT
							CODEMP as CODEMPVAC,
							PERINI,
							PERFIN,
							DIADIS + DIASBONO as DIASCANCELAR,
							MONTO
							FROM NPVACLIQUIDACION
							WHERE codemp= '$datocedula'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>