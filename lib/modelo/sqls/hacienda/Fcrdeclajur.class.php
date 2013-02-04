<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Fcrdeclajur extends BaseClases
{

	function sqlp($DECLARA)
  {
  	  $sql= "SELECT DISTINCT D.CODACT, A.RIFCON, A.TIPCON, B.RIFCON, B.NUMREF,B.NUMDEC, C.RIFCON, C.NOMCON,
						 C.DIRCON, C.RIFREP, C.NUMLIC, C.CAPSOC, to_char(C.FECINI,'DD/MM/YYYY') as fecini,
						 C.TIPEST, D.NUMDOC, D.MONACT, E.CODACT as CODIGO,
						 E.DESACT, E.AFOACT, E.MINOFAC, E.MINTRI,F.VALUNITRI,B.MODO,B.ANODEC
						 FROM FCCONREP A, FCDECLAR B, FCSOLLIC C, FCACTPIC D, FCACTCOM E, FCDEFINS F
						 WHERE
						 B.NUMDEC =('".$DECLARA."')
						 AND A.RIFCON=B.RIFCON AND C.RIFCON = B.RIFCON AND
						 (B.FUEING = F.CODPIC OR B.FUEING=F.CODAJUPIC) AND B.NUMREF=C.NUMLIC AND
						 C.NUMLIC=D.NUMDOC AND B.ANODEC=D.ANODEC
						 AND B.MODO=D.MODO
						 AND (D.CODACT)=(E.CODACT) AND
     					 B.ANODEC=E.ANOACT AND
     					 C.STALIC<>'C' and
     					 C.STALIC<>'N' and
     					 C.STALIC<>'S'
						 order by a.rifcon";
//H::PrintR($sql);exit;
	return $this->select($sql);
  }

 	function sqlp1($cod)
  {
  	  $sql= "SELECT MAX(TO_CHAR(FECDEC,'YYYY')) as cadena FROM FCDECLAR WHERE NUMDEC=('".$cod."')";

	return $this->select($sql);
  }
}