<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcmuldec extends baseClases
{
	function sqlp($CODDES,$CODHAS)
	{

$sql=    "select a.codmul as codigo,a.nommul as nombre,
		case when A.MODO='I' then 'Inicio del Ejercicio' WHEN A.MODO='E' then 'Cierre de Declaracion Estimada' WHEN A.MODO='D' then 'Cierre de Declaracion' end as modo,
		case when a.tipo= 'M' then 'Manual' WHEN a.tipo= 'A' then 'Automatica' end as tipo,
		case when a.tipdec ='E' then 'Estimada' WHEN a.tipdec ='D' then 'Definitiva' end as declaracion,
		b.diasdesde AS desde, b.diashasta as hasta, b.valor as valor,
		(select d.nomfue from  fcfuepre d where c.codfue=d.codfue) as fuente

       FROM FCMULTAS A, FCRANGOSMUL B, fcfuentesmul c
       WHERE
       A.CODMUL= B.CODMUL and
       a.codmul= c.codmul and
       a.codmul >= '".$CODDES."' AND
       a.codmul <= '".$CODDES."'

		ORDER BY a.codmul"; //H::PrintR($sql); exit;

return $this->select($sql);
	}

}
?>
