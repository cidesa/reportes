<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprresconnom extends baseClases
{

    function sql($especial,$tipnomesp1,$tipnomesp2,$con1,$con2,$tipcon)
    {
        if ($especial == 'S')
        {
        	//print"<pre> especial=S";
            $especial = " a.especial = 'S' AND
		A.CODNOMESP >= '$tipnomesp1' AND
		A.CODNOMESP <= '$tipnomesp2' AND ";
        }
        else
        {
            if ($especial == 'N'){
				//print"<pre> especial=N";
                $especial = " a.especial = 'N' AND";}
            else
            if ($especial == 'T')
			$especial = "";
			//print"<pre> especial=T";
                
        }
        $sql = " SELECT DISTINCT(A.CODCON), B.NOMCON,B.CODPAR, A.CODNOM as codnom ,A.NOMNOM as nomnom, A.ASIDED,
							SUM(CASE WHEN A.SALDO=0 THEN 0 ELSE 1 END ) AS CANT,
							SUM(CASE WHEN A.ASIDED='A' THEN A.SALDO ELSE 0 END) AS ASIGNA,
							SUM(CASE WHEN A.ASIDED='D' THEN A.SALDO ELSE 0 END) AS DEDUC ,
							SUM(CASE WHEN (A.ASIDED='P' ) THEN A.SALDO ELSE 0 END ) AS APORTE ,
						--    SUM(CASE WHEN A.ASIDED='P' THEN A.SALDO ELSE 0 END ) AS APORTE ,
							B.IMPCPT, b.codpar
							FROM NPNOMCAL A, NPDEFCPT B

							WHERE
							--(B.IMPCPT) <> 'N' AND
							A.CODNOM >= '$con1' AND
							A.CODNOM <= '$con2' AND
							A.SALDO > 0  AND
							A.ASIDED LIKE '$tipcon' AND".$especial."
							B.CODCON = A.CODCON
							GROUP BY A.CODCON,B.NOMCON,A.CODNOM,A.NOMNOM,A.ASIDED, B.IMPCPT,b.codpar
							ORDER BY A.CODNOM, A.ASIDED, A.CODCON";
    //print"<pre> $sql=".$sql;exit;
    return $this->select($sql);
	}
	
	function tbf($codigo){
		$sql="select to_char(profec,'dd/mm/yyyy') as profec, to_char(ultfec,'dd/mm/yyyy') as ultfec from npnomina where codnom = '$codigo'";
		//print"<pre> $sql=".$sql;
		return $this->select($sql);
	}
	
	function cuantos($codigo,$tbgasided,$tbgcodcon){
		$sql="SELECT COUNT(DISTINCT(CODEMP)) as numero FROM NPNOMCAL WHERE codnom='$codigo' and asided='$tbgasided' and codcon = '$tbgcodcon'";
		//print"<pre> $sql=".$sql;
		return $this->select($sql);
	}
	
}
?>
