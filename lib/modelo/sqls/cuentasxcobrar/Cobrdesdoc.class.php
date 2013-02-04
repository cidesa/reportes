<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cobrdesdoc extends baseClases
{
	function sqlp($coddes,$codhas,$tipctedes,$tipctehas) //
	{

$sql= "SELECT distinct A.REFDOC, B.CODPRO AS CODPRO ,E.CODTIPCLI AS CODTIPO, E.NOMTIPCTE AS TIPO
FROM COBDESDOC A, FACLIENTE B, COBTIPDES C ,COBDOCUME D, FATIPCTE E
WHERE

B.FATIPCTE_ID  =E.CODTIPCLI AND
A.CODCLI       =B.CODPRO AND
A.CODDES       =C.CODDES AND
A.REFDOC      >= '".$coddes."' AND
A.REFDOC      <= '".$codhas."' AND
B.FATIPCTE_ID >= '".$tipctedes."' AND
B.FATIPCTE_ID <= '".$tipctehas."' AND
B.CODPRO       =D.CODCLI AND
A.REFDOC       =D.REFDOC AND
D.STADOC='A'
ORDER BY A.REFDOC";
//H::PrintR($sql);
return $this->select($sql);
	}

  function sqlp1($codcli,$refdoc)
	{

$sql= " SELECT distinct A.REFDOC AS CODIGO, B.NOMPRO AS NOMBRE,B.CODPRO as codpro, C.DESDES AS DESCUENTO, A.FECDES AS FECHA, A.MONDES AS MONTO
    FROM COBDESDOC A, FACLIENTE B, COBTIPDES C ,COBDOCUME D, FATIPCTE E
   WHERE
B.FATIPCTE_ID  =E.CODTIPCLI AND
A.CODCLI       =B.CODCLI AND
A.CODDES       =C.CODDES AND
B.FATIPCTE_ID  =E.CODTIPCLI     AND
A.CODCLI       =B.CODPRO AND
A.CODDES       =C.CODDES AND
B.CODPRO       ='".$codcli."' AND
B.CODPRO  ='".$codcli."' ORDER BY B.CODPRO,A.REFDOC";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

}
