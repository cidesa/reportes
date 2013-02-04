<?php
require_once("../../lib/modelo/baseClases.class.php");

class Disponibilidadpresunomina extends baseClases
{

    function sqlp ($tipnomdes)//DATOS DEL EMPLEADO
	{
		$sql = "SELECT D.CODCAT||'-'||C.CODPAR as codpre
							FROM NPNOMCAL A, NPASICAREMP B, NPDEFCPT C,NPCONCEPTOSCATEGORIA D
							WHERE
							A.CODNOM ='$tipnomdes' AND 
							A.CODNOM=B.CODNOM AND
							A.CODEMP=B.CODEMP AND
							A.CODCAR=B.CODCAR AND
							A.CODCON=C.CODCON AND
							C.CODCON=D.CODCON AND
							D.CODCON=A.CODCON AND
							--B.STATUS='V' AND
							A.SALDO>0 
							UNION
							(SELECT B.CODCAT||'-'||C.CODPAR as codpre
							FROM NPNOMCAL A, NPASICAREMP B, NPDEFCPT C
							WHERE
							A.CODNOM ='$tipnomdes' AND 
							A.CODNOM=B.CODNOM AND
							A.CODEMP=B.CODEMP AND
							A.CODCAR=B.CODCAR AND
							A.CODCON=C.CODCON AND
							--B.STATUS='V' AND
							A.SALDO>0 AND
							A.CODCON NOT IN (SELECT CODCON FROM npconceptoscategoria))
							ORDER BY CODPRE";
							
								
	
		return $this->select($sql);
	}
	
	function sqlnomb($codigo)
	{
		$sql="SELECT DISTINCT(nomnom) as nombre FROM NPNOMCAL WHERE
			 codnom='$codigo'";
		
		return $this->select($sql);
	}
	
	function sqlfec($codigo)
	{
		$sql="SELECT ULTFEC as fecha FROM NPNOMINA WHERE CODNOM='001'";
		
		return $this->select($sql);
	}
	
	function sqlfec2($codigo)
	{
		$sql="SELECT PROFEC as fecha2 FROM NPNOMINA WHERE CODNOM='001'";
		
		return $this->select($sql);
	}
	
	function sqldes($codigo)
	{
		$sql="SELECT NOMPRE as nombre FROM CPDEFTIT WHERE CODPRE='$codigo'";
		
		return $this->select($sql);
	}
	
	function sqlasig($codigo)
	{
		$sql="SELECT MONASI as asiini FROM CPASIINI WHERE CODPRE='$codigo' AND PERPRE='00'";
		
		return $this->select($sql);
	}
	
	/*function sqlasig($codigo)
	{
		$sql="SELECT MONDIS as saldo_dis FROM CPASIINI WHERE CODPRE='$codigo' AND PERPRE='00'";
		
		return $this->select($sql);
	}*/
	
	function sqldisp($codigo)
	{
		$sql="SELECT MONDIS as saldo_dis FROM CPASIINI WHERE CODPRE='$codigo' AND PERPRE='00'";
		
		return $this->select($sql);
	}
	
	function sqlmcier($codigo)
	{
		$sql="SELECT coalesce(SUM(MONTO),0) as monto_cierre FROM NPCIENOM WHERE CODPRE='$codigo' AND (ASIDED='A' OR ASIDED='P')";
		return $this->select($sql);
	}
	
	function sqlmoprt($codigo)
	{
		$sql="SELECT coalesce(SUM(B.MONRET),0) as monto_opret FROM OPORDPAG A,OPRETORD B WHERE A.NUMORD = B.NUMORD AND B.NUMRET = 'NOASIGNA' 
				 AND A.TIPCAU = 'OP/N' AND B.CODPRE='$codigo'";
				 
		return $this->select($sql);
	}
}