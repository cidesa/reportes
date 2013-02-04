<?php
require_once("../../lib/modelo/baseClases.class.php");

class ciudadanos extends baseClases
{
 	public static function catalogo_atunidades_coduni($objhtml)
	{
		$sql="SELECT coduni, desuni from atunidades where ( coduni like '%V_0%' AND desuni like '%V_1%' ) ORDER BY coduni";

		$catalogo = array(
		    $sql,
		    array('Codigo Unidad','Descripción'),
		    array($objhtml),
		    array('coduni'),
		    100
		    );

	    return $catalogo;
	}

 	public static function catalogo_atsolici_ceddes($objhtml)
	{
		$sql="SELECT cedula, nombre from atsolici a, ataudiencias b where b.atsolici_id=a.id and ( a.cedula like '%V_0%' AND a.nombre like '%V_1%' ) ORDER BY a.cedula";

		$catalogo = array(
		    $sql,
		    array('Cédula','Nombre Solicitante'),
		    array($objhtml),
		    array('cedula'),
		    100
		    );

	    return $catalogo;
	}

 	public static function catalogo_atsolici_cedula($objhtml)
	{
		$sql="select cedula, nombre from atsolici where ( cedula like '%V_0%' AND nombre like '%V_1%' ) ORDER BY cedula";

		$catalogo = array(
		    $sql,
		    array('Cédula','Nombre Solicitante'),
		    array($objhtml),
		    array('cedula'),
		    100
		    );

	    return $catalogo;
	}


}
?>