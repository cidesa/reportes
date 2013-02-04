<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cobrdettra extends baseClases
{
	function sqlp($coddes,$codhas,$codctedes,$codctehas,$fechades,$fechahas,$tipmovdes,$tipmovhas,$tipctedes,$tipctehas) //
	{

$sql= "SELECT A.NUMTRA, A.DESTRA, E.NOMTIPCTE AS TIPO,E.ID AS CODTIPO,C.CODPRO as CODPRO , C.NOMPRO
FROM COBTRANSA A,
FATIPMOV B,
FACLIENTE C,
COBDETTRA D,
FATIPCTE E
WHERE A.NUMTRA >= '".$coddes."' AND
A.NUMTRA <= '".$codhas."' AND
A.CODCLI >=  '".$codctedes."' AND
A.CODCLI <= '".$codctehas."' AND
A.FATIPMOV_ID >= '".$tipmovdes."' AND
A.FATIPMOV_ID <= '".$tipmovhas."' AND
A.FECTRA >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECTRA <= to_date('".$fechahas."','yyyy/mm/dd') AND


STATUS='A' AND
C.FATIPCTE_ID=E.ID AND
A.NUMTRA=D.NUMTRA AND
D.CODCLI=C.CODPRO AND
A.FATIPMOV_ID=B.ID
ORDER BY C.CODPRO,A.NUMTRA";
//H::PrintR($sql); C.FATIPCTE_ID >= '".$tipctedes."' AND C.FATIPCTE_ID <= '".$tipctehas."' AND
return $this->select($sql);
	}

   function sqlp1($numtra,$codtipo,$codpro)
	{

$sql= "SELECT distinct (A.NUMTRA), to_char( A.FECTRA,'dd/mm/yyyy') as FECTRA,B.DESMOV, A.DESTRA, a.montra, C.CODPRO as CODPRO, C.FATIPCTE_ID as tipcli
FROM COBTRANSA A,
FATIPMOV B,
FACLIENTE C,
COBDETTRA D,
FATIPCTE E
WHERE
C.CODPRO = A.CODCLI AND
C.FATIPCTE_ID = E.ID AND
C.FATIPCTE_ID = '".$codtipo."' and
A.NUMTRA= '".$numtra."' and
C.CODPRO = '".$codpro."'
ORDER BY C.CODPRO,A.NUMTRA";
//H::PrintR($sql);exit;
return $this->select($sql);
	}

	function sqlp2($numtra,$codigo)
	{

$sql= "SELECT distinct F.REFDOC, F.MONDOC, D.MONPAG AS PAGO, D.MONDSC AS DESCUENTO, D.MONREC AS RECARGO, F.SALDOC
FROM COBTRANSA A,
FACLIENTE C,
COBDETTRA D,
FATIPCTE E,
COBDOCUME F
WHERE
A.NUMTRA =D.NUMTRA AND
A.CODCLI = C.CODPRO AND
C.CODPRO = F.CODCLI AND
C.FATIPCTE_ID = E.ID AND
D.REFDOC = F.REFDOC AND
A.NUMTRA ='".$numtra."' AND
C.FATIPCTE_ID = '".$codigo."'
--ORDER BY C.CODPRO";
//H::PrintR($sql);
return $this->select($sql);
	}

}
