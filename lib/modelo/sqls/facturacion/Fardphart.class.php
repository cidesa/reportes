<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardphart extends baseClases
{
	function sqlp($CODDES,$CODHAS,$codclides,$codclihas,$codartdes,$codarthas,$codalmdes,$codalmhas,$fechades,$fechahas,$estatus,$tiprefe)
	{


$tiporefe='';
$estatusdesp='';
if ($estatus =='A' OR $estatus =='N')
          {
	$estatusdesp=  "AND STADPH ='".$estatus."' ";
          }
if ($tiprefe =='NE' OR $tiprefe =='D' OR $tiprefe =='R')
          {
	$tiporefe=  "AND TIPNOT ='".$tiporefe."' ";

          }

$sql= "SELECT
A.DPHART,
A.DESDPH,
A.FECDPH,
A.MONDPH,
A.CODALM,
A.OBSDPH,
A.CODCLI,
A.FORDESP,
G.NOMPRO AS NOMPRO,
B.CODART,
C.DESART,
C.UNIMED,
B.NUMLOT,
B.CANDPH,
B.CANDEV,
C.COSPRO,
B.MONTOT,
CASE WHEN A.STADPH='A' THEN 'Activo' WHEN
A.STADPH='N' THEN 'Anulado' ELSE 'Ambas' END,
TRIM(E.NOMALM) as NOMALM--,F.NOMDES
FROM CADPHART A,CAARTDPH B,CAREGART C,CADEFALM E,FACLIENTE G--,FAFORDES F
WHERE
B.DPHART=A.DPHART AND
C.CODART=B.CODART AND
E.CODALM=A.CODALM AND
--F.ID=A.FORDESP AND
G.CODPRO=A.CODCLI AND
A.DPHART >= '".$CODDES."' AND
A.DPHART <= '".$CODHAS."' AND
A.CODCLI >= '".$codclides."' AND
A.CODCLI <= '".$codclihas."' AND
B.CODART >= '".$codartdes."' AND
B.CODART <= '".$codarthas."' AND
A.CODALM >= '".$codalmdes."' AND
A.CODALM <= '".$codalmhas."' AND
A.FECDPH >= to_date('".$fechades."','yyyy/mm/dd') AND
A.FECDPH <= to_date('".$fechahas."','yyyy/mm/dd')
".$estatusdesp."" .$tiporefe."
ORDER BY A.DPHART";
//H::PrintR($sql);exit;

return $this->select($sql);
	}

	function sqlp1($codpro)
	{

	$sql="SELECT distinct
B.CODART,
C.DESART,
CASE WHEN A.TIPDPH='NE' THEN 'Entrega' WHEN
A.TIPDPH='D' THEN 'Devolucion' WHEN
A.TIPDPH='R' THEN 'Requisicion' END,
C.UNIMED,
B.NUMLOT,
B.CANDPH,
B.CANDEV,
C.COSPRO,
A.REQART,
B.MONTOT
	    FROM CADPHART A,CAARTDPH B,CAREGART C,CADEFALM E,FACLIENTE G--,FAFORDES F
	    WHERE
           B.DPHART=A.DPHART AND
		   C.CODART=B.CODART AND
           E.CODALM=A.CODALM AND
        ---   F.ID=A.FORDESP AND
           G.CODPRO=A.CODCLI AND
           A.CODCLI='".$codpro."'
	      ORDER BY B.CODART";
//H::PrintR($sql);exit;
		return $this->select($sql);

	}
	function sqlp2($codart,$tipdph,$reg)
	{

$sql="";
if ($tipdph == 'Entrega')
      {
     $sql= "SELECT CANSOL as CANTIDAD FROM FAARTNOT WHERE NRONOT='".$reg."' AND CODART='".$codart."'";
      }
else if ($tipdph == 'Requisicion')
       {
  	    $sql= "SELECT CANREQ as CANTIDAD FROM CAARTREQ WHERE REQART='".$reg."' AND CODART='".$codart."'";
       }
//H::PrintR($tipdph);
//H::PrintR($codart);
		return $this->select($sql);

	}
	}
?>
