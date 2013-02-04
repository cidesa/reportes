<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrsolvencia extends baseClases
{
	function sqlp($CODDES,$CODHAS,$codtipsoldes,$codtipsolhas,$fecdes,$fechas)
	{

$sql= "SELECT A.CODSOL, A.CODCAT, A.NUMLIC, A.RIFCON, A.NOMCON, A.DIRCON,
						SUBSTR(TO_CHAR(A.FECEXP,'DD/MM/YYYY'),1,2) as diaexp,
						SUBSTR(TO_CHAR(A.FECEXP,'DD/MM/YYYY'),4,2) as mesexp,
						SUBSTR(TO_CHAR(A.FECEXP,'DD/MM/YYYY'),7,4) as anoexp,
						SUBSTR(TO_CHAR(A.FECVEN,'DD/MM/YYYY'),1,2) as diaven,
						SUBSTR(TO_CHAR(A.FECVEN,'DD/MM/YYYY'),4,2) as mesven,
						SUBSTR(TO_CHAR(A.FECVEN,'DD/MM/YYYY'),7,4) as anoven,
						A.MOTIVO, B.CODTIP, B.DESTIP, B.PRIVMSG
						FROM FCSOLVENCIA A,FCTIPSOL B
						WHERE A.CODSOL>=('".$CODDES."') AND
						A.CODSOL<=('".$CODHAS."') AND
						A.CODTIP>=('".$codtipsoldes."') AND
						A.CODTIP<=('".$codtipsolhas."') AND
						A.FECEXP>=TO_DATE('".$fecdes."','DD/MM/YYYY') AND
						A.FECEXP<=TO_DATE('".$fechas."','DD/MM/YYYY') AND
						A.CODTIP=B.CODTIP" ;// H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
