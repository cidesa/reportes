<?php
require_once("../../lib/modelo/baseClases.class.php");

class Instr8 extends baseClases
{
 	public static function catalogo_forcargos($objhtml)
	{
	 $sql="select distinct(codcar) as codcar, nomcar as nomcar from forcargos where ( codcar like '%V_0%' AND nomcar like '%V_1%' ) order by codcar ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Cargo','Descripción'),
		    array($objhtml),
		    array('codcar'),
		    100
		    );

	    return $catalogo;
	}
 	public static function catalogo_fordefcatpre_sec($objhtml)
	{
	 $sql="select distinct(substr(codcat,1,2)) as sector from fordefcatpre where ( substr(codcat,1,2) like '%V_0%' ) order by substr(codcat,1,2) ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Sector'),
		    array($objhtml),
		    array('sector'),
		    100
		    );

	    return $catalogo;
	}
 	public static function catalogo_fordefcatpre_pro($objhtml)
	{
	 $sql="select distinct(substr(codcat,4,2)) as prog from fordefcatpre where ( substr(codcat,4,2) like '%V_0%' ) and trim(substr(codcat,4,2))<>'' order by substr(codcat,4,2) ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Programa'),
		    array($objhtml),
		    array('prog'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_fordefcatpre_act($objhtml)
	{
	 $sql="select distinct(substr(codcat,13,2)) as act from fordefcatpre where ( substr(codcat,13,2) like '%V_0%' ) and trim(substr(codcat,13,2))<>'' order by substr(codcat,13,2) ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Actividad'),
		    array($objhtml),
		    array('act'),
		    100
		    );

	    return $catalogo;
	}

}

