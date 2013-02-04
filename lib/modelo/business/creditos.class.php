<?php
require_once("../../lib/modelo/baseClases.class.php");

class Creditos extends baseClases
{

	public static function catalogo_codcta($objhtml)
		{
			$sql="SELECT DISTINCT(codcta) as codigo, descta as descripcion FROM CONTABB where ( codcta like '%V_0%' and descta like '%V_1%') order by codcta";

			$catalogo = array(
			    $sql,
			    array('Cuenta Contable','Descripcion'),
			    array($objhtml),
			    array('codigo'),
			    100
			    );

		    return $catalogo;
		}



}