<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcdescto extends baseClases
{
	function sqlp($CODDES,$CODHAS,$TIPDESC)
	{

$sql=   "select A.CODDES AS CODIGO, A.nomdes AS NOMBRE,B.DIASDESDE AS DESDE, B.DIASHASTA AS HASTA, D.DESREC AS RECAUDOS,B.VALOR AS valor,
 CASE WHEN A.tipo='P' THEN 'Pronto Pago' WHEN
        A.tipo='R' THEN 'Eventuales' ELSE 'Periódico' END as tipo
         FROM fcdefdesc A, fcrangosdes B,fcdefrecdes C, CARECAUD D
	  WHERE
	        A.CODDES=B.CODDES AND
	        A.CODDES=C.CODDES AND
	        D.CODREC=C.CODREC AND
		A.CODDES >= '".$CODDES."' AND
		A.CODDES <= '".$CODHAS."' AND
		A.TIPO = '".$TIPDESC."'
		ORDER BY A.CODDES";// H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
