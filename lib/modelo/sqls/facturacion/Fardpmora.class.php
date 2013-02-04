<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fardpmora extends baseClases
{
	function sqlp($codclides,$codclihas,$numdes,$numhas,$fecdes,$fechas)
	{
		$sql="SELECT
					c.codpro as codclie,
					c.nompro as cliente,
					c.rifpro as rif,
					b.reffac as numero,
					TO_CHAR(b.fecfac,'DD/MM/YYYY') as ffactura,
					a.billleading as bl,
					d.desart as origendestino,
					a.orddespacho as orddespacho,
					a.guia as guiatransporte,
					a.nronot as nnota,
					a.chofer as chofer,
					a.placa as placa,
					TO_CHAR(A.feclleg,'DD/MM/YYYY') as fllegada,
					TO_CHAR(A.fecsal,'DD/MM/YYYY') as fsalida,
					a.horsal as hllegada,
					a.horlleg as hsalida,
					a.contenedores as contenedor,
					a.kg as kg,
					a.prod as producto,
					a.cajas as cajas,
					a.precio as pdestino
				FROM
					FAARTFAC a,
					FAFACTUR b,
					FACLIENTE c,
					CAREGART d
				WHERE
					a.reffac=b.reffac AND
					a.codart=d.codart AND
					b.codcli=c.codpro AND
					b.codcli >= '$codclides'  AND
					b.codcli <= '$codclihas' AND
					b.reffac >= '$numdes' AND
					b.reffac <= '$numhas' AND
					b.fecfac >= to_date('$fecdes','yyyy/mm/dd') AND
					b.fecfac <= to_date('$fechas','yyyy/mm/dd')
				ORDER BY
					b.reffac";
			//print "<pre>".$sql;exit;
		return $this->select($sql);



	}
}
?>
