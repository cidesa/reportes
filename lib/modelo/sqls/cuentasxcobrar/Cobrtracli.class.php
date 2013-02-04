<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cobrtracli extends baseClases
{
	function sqlp($coddes,$codhas,$codctedes,$codctehas,$fechades,$fechahas,$codmovdes,$codmovhas,$tipctedes,$tipctehas)
	{

$sql= "SELECT A.NUMTRA,
A.REFDOC,
D.FECTRA,
D.DESTRA,
A.MONPAG,
A.MONDSC,
A.MONREC,
A.TOTPAG,
B.DESMOV,
C.CODCLI AS CODPRO,
C.NOMCLI,
C.NITCLI,
E.NOMTIPCTE as tipo,E.CODTIPCLI as codtipo
FROM COBDETTRA A, COBTIPMOV B, cobclient C, COBTRANSA D, FATIPCTE E
WHERE
C.TIPCLI=E.CODTIPCLI AND
A.NUMTRA=D.NUMTRA AND
D.CODMOV=B.codmov AND
A.CODCLI=C.CODCLI AND
C.CODCLI >= '".$codctedes."' AND
C.CODCLI <= '".$codctehas."' AND

A.NUMTRA >= '".$coddes."' AND
A.NUMTRA <= '".$codhas."' AND

D.CODMOV >= '".$codmovdes."' AND
D.CODMOV <= '".$codmovhas."' AND

D.FECTRA >= to_date('".$fechades."','yyyy/mm/dd') AND
D.FECTRA <= to_date('".$fechahas."','yyyy/mm/dd') AND

C.TIPCLI >= '".$tipctedes."' AND
C.TIPCLI <= '".$tipctehas."' AND
D.STATUS='A'
ORDER BY D.CODCLI, D.FECTRA,A.NUMTRA,  D.CODMOV";
//H::PrintR($sql);
return $this->select($sql);
	}

  function sqlp1($codcli,$tipo)
	{

$sql= "SELECT A.NOMCLI,A.NITCLI, B.NUMTRA
        FROM cobclient A, COBDETTRA B
        where
        	A.CODCLI=B.CODCLI AND
            A.CODCLI='".$codcli."' AND
            A.TIPCLI='".$tipo."' ORDER BY A.CODCLI";
//H::PrintR($sql);exit;
return $this->select($sql);
	}
  function sqlp2($codcli,$numtra)
	{

$sql= "SELECT B.FECTRA,B.NUMTRA,B.REFDOC, A.MONPAG,a.mondsc,A.MONREC, A.TOTPAG
        FROM cobclient A, COBDETTRA B
        where
        	A.CODCLI=B.CODCLI AND
            A.CODCLI='".$codcli."' AND
            B.=NUMTRA'".$numtra."' ORDER BY A.CODCLI";
//H::PrintR($sql);
return $this->select($sql);
	}


}
