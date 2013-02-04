<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrlisliccan extends baseClases
{
	function sqlp($cod1,$cod2,$estatus)
	{
      $sql= "SELECT A.NUMLIC,A.NOMNEG,A.DIRPRI,
					     to_char(B.FECSUS,'DD/MM/YYYY') AS FECHA,
                         B.MOTSUS,B.TOMO,B.NUMERO,B.RESOLU,A.rifcon
                         FROM FCSOLLIC A,FCSUSCAN B
                         WHERE
                         A.NUMLIC>=('".$cod1."') AND
                         A.NUMLIC<=('".$cod2."') AND
                         A.STALIC=('".$estatus."') AND
                         A.NUMLIC=B.NUMLIC
                         GROUP BY A.NUMLIC,A.NOMNEG,A.DIRPRI,B.FECSUS,B.MOTSUS,B.TOMO,B.NUMERO,B.RESOLU,A.RIFCON";
//H::PrintR($sql); exit;

return $this->select($sql);
	}
     	function sqlpca($cod1,$cod2)
	{
      $sql= "select distinct(rtrim(funsus)) as funsus from fcsuscan
									   where rtrim(funsus)>=rtrim('".$cod1."') and
											 rtrim(funsus)<=rtrim('".$cod2."')";
// H::PrintR($sql); exit;

return $this->select($sql);
	}

function sqlp1($codigo)
	{
      $sql= "SELECT A.NUMLIC,B.NUMLIC,A.STALIC,B.ESTLIC,to_char(B.FECSUS,'DD/MM/YYYY')as fecha,
						 B.TOMO,B.NUMERO,B.RESOLU
					     FROM FCSOLLIC A, FCSUSCAN B
					     WHERE A.NUMLIC=('".$codigo."') AND
					     		A.NUMLIC=B.NUMLIC AND
					     		A.STALIC=B.ESTLIC
					     ORDER BY A.NUMLIC,B.FECSUS DESC";
//H::PrintR($sql); exit;

return $this->select($sql);
	}


}
?>
