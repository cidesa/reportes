<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprautvac extends baseClases {

  function sqlp($codempdes, $codemphas, $fecsalida)
  {
	$sql="SELECT DISTINCT
			A.CODEMP,
			B.CEDEMP,
			B.NOMEMP,
			B.FECING,
			A.FECDES,
			A.FECHAS,
			A.FECVAC,
			C.PERINI,
			C.PERFIN,
			C.DIASVAC
			FROM
			NPVACSALIDAS A,
			NPHOJINT B,
			NPVACSALIDAS_DET C
			WHERE
			A.CODEMP='$codempdes' AND
			A.CODEMP=B.CODEMP AND
                     a.fecdes=to_date('$fecsalida', 'dd/mm/yyyy') and
                      A.CODEMP=C.CODEMP and
                     A.FECVAC=C.FECVAC 
            ORDER BY A.CODEMP";

   //H::PrintR($sql);exit;
   return $this->select($sql);
  }

}
?>