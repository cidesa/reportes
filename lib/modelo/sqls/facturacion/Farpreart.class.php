<?php
require_once("../../lib/modelo/baseClases.class.php");

class Farpreart extends baseClases
{
	function sqlp($premin,$premax,$codclides,$codclihas,$FECDES,$FECHAS,$CODDES,$CODHAS)
	{

	$sql= " SELECT
		A.REFPRE,
		A.FECPRE,
		A.DESPRE,
		A.OBSERV,
		A.CODCLI,
		B.CODART,
		B.CANSOL,
		C.DESART,
		C.UNIMED,
		B.PRECIO,
		B.TOTART,
		D.NOMPRO
	FROM FAPRESUP A,FADETPRE B,
		CAREGART C,FACLIENTE D,FACONPAG E
	WHERE
	    A.FACONPAG_ID=E.ID AND
		B.REFPRE=A.REFPRE AND
		C.CODART=B.CODART AND
		D.CODPRO=A.CODCLI AND
		A.REFPRE >= '".$premin."' AND
		A.REFPRE <= '".$premax."'AND
		A.CODCLI >= '".$codclides."' AND
		A.CODCLI <= '".$codclihas."' AND
		B.CODART >= '".$CODDES."' AND
		B.CODART <= '".$CODHAS."' AND
		A.FECPRE >= to_date('".$FECDES."','yyyy/mm/dd') AND
		A.FECPRE <= to_date('".$FECHAS."','yyyy/mm/dd')
		ORDER BY A.REFPRE";
//H::PrintR($sql);
return $this->select($sql);
	}

	function sqlp2($codpro) // ciclo interno
	{

	$sql="
   select a.reffac,b.DESPRE,b.fecpre
      from  FAFACTUR A,FAPRESUP B,
           CAREGART C,
           FADETPRE F
      where
             f.codart = c.codart and b.refpre=a.reffac and
              a.codcli='".$codpro."' order by c.codart ";
		//H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}

	function sqlp1($refe) // ciclo interno
	{

	$sql="  select c.codart, c.desart, c.exitot, c.preart,c.unimed, f.cansol, f.precio, f.totart
      from  FAFACTUR A,
           CAREGART C,
           FADETPRE F
      where
             f.codart = c.codart and
             A.reffac='".$refe."' order by c.codart ";
		//H::PrintR($sql);
		return $this->select($sql);
		//print $sql; exit;
	}

}
?>
