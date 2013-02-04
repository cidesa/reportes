<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistrelgenasided extends baseClases {

	function sql($especial, $tipnomdes, $tipnomhas, $fecdes, $fechas) {
		if ($especial == 'S') {
			$condicion = " and g.especial = 'S'";
		} else {
			$condicion = "";
		}
		$sql = "SELECT
							I.nomnom AS nomnom,
							i.codnom as codnom,
							(CASE WHEN a.opecon='A' THEN coalesce(sum(G.monto),0) ELSE 0 END) as ASIGNA,
							(CASE WHEN a.opecon='D' THEN coalesce(sum(G.monto),0) ELSE 0 END) as DEDUC
							FROM  NPHISCON G, NPNOMINA I, npdefcpt a
							WHERE
							g.especial='$especial' AND
							(g.CODNOM) >= ('$tipnomdes')
							AND(g.CODNOM) <= ('$tipnomhas')
						--	AND G.codnom=B.codnom
							AND I.codnom=g.codnom
						--	AND B.STATUS='V' and
	                        and g.codcon=a.codcon and a.impcpt = 'S'
							AND (G.CODNOM) >= ('$tipnomdes')
							AND (G.CODNOM) <= ('$tipnomhas')

							AND (G.CODNOM) >= ('$tipnomdes.')
							AND (G.CODNOM) <= ('$tipnomhas')" . $condicion . "

							AND rtrim(G.CODCAR)=rtrim(g.CODCAR)
							AND G.CODEMP=g.CODEMP and  g.fecnom>=to_date('$fecdes','DD/MM/YYYY')
	                        and g.fecnom<=to_date('$fechas','DD/MM/YYYY')
							group by i.codnom, i.nomnom,a.opecon
							ORDER BY i.codnom";
		//print"<pre> sql=".$sql;exit;
		return $this->select($sql);
	}
}
?>