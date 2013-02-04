<?php
require_once("../../lib/modelo/baseClases.class.php");

class Compras extends baseClases
{
// Desde Aqui se Comenzaroan a Hacer los Catalogos para la Depuracion de Reportes Base... 10-06-2009

		public static function catalogo_salida($objhtml)
	{
		$sql="Select distinct(codtipsal) as codigo, destipsal from catipsal where ( codtipsal like '%V_0%' AND destipsal like '%V_1%' ) order by codtipsal";

		$catalogo = array(
		    $sql,
		    array('Tipo de Salida','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

			public static function catalogo_gruporecac($objhtml)
	{
		$sql="Select distinct(codtiprec) as codigo, destiprec from catiprec where ( codtiprec like '%V_0%' AND destiprec like '%V_1%' ) order by codtiprec";

		$catalogo = array(
		    $sql,
		    array('Tipo de Salida','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_careqart($objhtml)
	{
		$sql="SELECT DISTINCT(REQART) as codigo, desreq as Descripcion FROM CAREQART where ( reqart like '%V_0%' AND desreq like '%V_1%' ) order by REQART";

		$catalogo = array(
		    $sql,
		    array('Codigo de Requisicion','Descripcion'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_medcom($objhtml)
	{
	 	$sql="select distinct(codmedcom) as codigo, desmedcom as descripcion FROM camedcom";

		$catalogo = array(
		    $sql,
		    array('Código','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_procom($objhtml)
	{
	 	$sql="select distinct(codprocom) as codigo, desprocom as descripcion FROM caprocom";

		$catalogo = array(
		    $sql,
		    array('Código','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}


		public static function catalogo_careqart1($objhtml)
	{
		$sql="SELECT DISTINCT(REQART) as codigo, desreq as Descripcion FROM CASOLART where ( reqart like '%V_0%' AND desreq like '%V_1%' ) order by REQART";

		$catalogo = array(
		    $sql,
		    array('Codigo de Requisicion','Descripcion'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}



	public static function catalogo_catuni($objhtml)
	{
	 	$sql="select distinct(codcat) as codigo, nomcat as descripcion FROM npcatpre";

		$catalogo = array(
		    $sql,
		    array('Código','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_codart($objhtml)
	{
	 $sql="select distinct(codart) as codart, desart  from caregart where ( codart like '%V_0%' AND desart like '%V_1%' ) order by codart ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codart'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_casolart($objhtml)
	{
	 	$sql="select reqart as solicitud, desreq as descripcion from casolart where ( reqart like '%V_0%' AND desreq like '%V_1%' ) order by reqart";

		$catalogo = array(
		    $sql,
		    array('Numero de Pedido','Descripción'),
		    array($objhtml),
		    array('solicitud'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_caprovee($objhtml)
	{
	 $sql="select a.rifpro as rifpro, a.nompro as nompro from caprovee a where  (a.rifpro like '%V_0%' AND a.nompro like '%V_1%') order by a.rifpro   ";

 		$catalogo = array(
		    $sql,
		    array('RIF Del Proveedor','Nombre Proveedor'),
		    array($objhtml),
		    array('rifpro'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_cotiza($objhtml)
	{
	 $sql="select refcot as codigo,descot as descripcion from CACOTIZA where  (refcot like '%V_0%' AND descot like '%V_1%') order by refcot ";

 		$catalogo = array(
		    $sql,
		    array('RIF Del Proveedor','Nombre Proveedor'),
		    array($objhtml),
		    array('rifpro'),
		    100
		    );

	    return $catalogo;
	}


}