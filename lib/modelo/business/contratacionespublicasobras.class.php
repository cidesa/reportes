<?php
require_once("../../lib/modelo/baseClases.class.php");

class Contratacionespublicasobras extends baseClases
{
        public static function catalogo_liactas_numact($objhtml)
	{
	   $sql="SELECT numact as numact, numcont as numcont FROM Liactas where ( numact like '%V_0%' )  order by numact";

		$catalogo = array(
		    $sql,
		    array('Nro. Acta','Nro. Contrato'),
		    array($objhtml),
		    array('numact'),
		    100
		    );

	    return $catalogo;
	}
        
    
}
?>
