<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrlicencia extends baseClases
{
	function sqlp($numlicdes,$anodeclara)
	{

	$sql="SELECT DISTINCT A.NUMLIC, A.RIFCON, B.ANODEC as anodec,
      			 A.CATCON, A.NOMNEG,A.RIFREP,C.NOMCON, A.DIRPRI,to_char(FECINILIC,'DD/MM/YYYY') AS INI,
				 to_char(A.FECVEN,'DD/MM/YYYY') AS FIN,C.NACCON,C.TIPCON,D.DESTIPLIC as des,A.CODTIPLIC
				 FROM FCSOLLIC A,FCACTPIC B,FCCONREP C,FCTIPLIC D
				 WHERE
     			 A.NUMLIC=('".$numlicdes."') AND
     			 A.RIFCON=C.RIFCON AND
     			 A.NUMLIC=B.NUMDOC AND
     			 B.ANODEC=('".$anodeclara."') AND
     			 A.CODTIPLIC=D.CODTIPLIC AND
     			 A.STALIC<>'C' and
     			 A.STALIC<>'N' and
     			 A.STALIC<>'S'
				 ORDER BY
      			 A.NUMLIC";

	 //H::PrintR($sql); exit;
return $this->select($sql);

	}

}
?>
