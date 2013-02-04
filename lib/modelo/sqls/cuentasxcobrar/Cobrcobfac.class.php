<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cobrcobfac extends baseClases
{
	function sqlp($coddes,$codhas,$codclides,$codclihas,$reffacdes,$reffachas,$fechades,$fechahas,$tipctedes,$tipctehas)
	{


$sql= "SELECT C.CODPRO AS  CODCLI, C.TIPO AS CODTIPO, E.NOMTIPCTE AS TIPO, A.NUMTRA
FROM COBTRANSA A,
FACLIENTE C,
COBDETTRA D,
FATIPCTE E,
COBDOCUME F
WHERE F.REFDOC=D.REFDOC AND
C.CODPRO = A.CODCLI AND
C.CODPRO = F.CODCLI AND
A.NUMTRA >= '".$coddes."' AND
A.NUMTRA <= '".$codhas."' AND
A.CODCLI >= '".$codclides."' AND
A.CODCLI <= '".$codclihas."' AND
F.REFdoc >= '".$reffacdes."' AND
F.REFdoc <= '".$reffachas."' AND
A.FECTRA >= to_date('".$fechades."','dd/mm/yyyy') AND
A.FECTRA <= to_date('".$fechahas."','dd/mm/yyyy') AND
C.FATIPCTE_ID >= '".$tipctedes."' AND
C.FATIPCTE_ID <= '".$tipctehas."' AND
STATUS='A' AND
C.FATIPCTE_ID=E.ID AND
A.NUMTRA=D.NUMTRA AND
D.CODCLI=C.CODPRO
ORDER BY C.TIPO,C.CODPRO, E.CODTIPCLI";
//H::PrintR($sql); 
return $this->select($sql);
	}
  function sqlp1($numtra,$tipo,$codigo)
	{

$sql= "SELECT distinct a.NUMTRA,to_char(a.FECTRA,'dd/mm/yyyy') AS FECHA,a.DESTRA, C.NOMPRO AS NOMBRE, (F.MONDOC-F.DSCDOC+F.RECDOC) as MONDOCFROM,  F.REFDOC
FROM COBTRANSA A,
FACLIENTE C,
COBDETTRA D,
FATIPCTE E,
COBDOCUME F
WHERE F.STADOC='A' AND
C.CODPRO = A.CODCLI AND
C.CODPRO = F.CODCLI AND
C.FATIPCTE_ID =E.ID AND
a.NUMTRA=d.numtra and
F.REFDOC=d.refdoc and

C.CODPRO = '".$codigo."' and
a.NUMTRA = '".$numtra."'
ORDER BY a.NUMTRA";
//H::PrintR($sql);exit;  C.FATIPCTE_ID = '".$tipo."' and
return $this->select($sql);
	}

	function sql2($reffac,$codigo)
	{

$sql= "SELECT F.REFDOC, D.MONPAG AS PAGO, D.MONDSC AS DESCUENTO, D.MONREC AS RECARGO, D.TOTPAG AS TOTAL

FROM COBTRANSA A,
FACLIENTE C,
COBDETTRA D,
FATIPCTE E,
COBDOCUME F
WHERE
   A.NUMTRA      =D.NUMTRA AND
   A.CODCLI      = C.CODPRO AND
   C.CODPRO      = F.CODCLI AND
   C.FATIPCTE_ID =E.ID AND
F.REFDOC ='".$reffac."' AND F.REFDOC=D.REFDOC
ORDER BY C.CODPRO";//H::PrintR($sql); 
return $this->select($sql);
	}

}
