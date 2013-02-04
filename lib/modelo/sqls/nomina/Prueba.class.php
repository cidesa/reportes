<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Prueba extends baseClases{

	function sql($cod1,$cod2){
		$sql="SELECT
				CODCON as CODIGO,
				NOMCON AS DESCRIPCION,
				NOMEMP as EMPLEADO
			FROM
				NPASICONEMP
			WHERE
			 CODCON >='$cod1' AND
			 CODCON <='$cod2';";
		//print"<pre> sql=".$sql;exit;
		return $this->select($sql);
	}
}
?>