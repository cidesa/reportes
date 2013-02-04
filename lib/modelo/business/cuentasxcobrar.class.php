<?php
require_once("../../lib/modelo/baseClases.class.php");

class Cuentasxcobrar extends baseClases
{
	public static function catalogo_clientes($objhtml)
	{
		$sql="select distinct A.CODCLI as codigo, A.NOMCLI AS nombre from cobclient A, COBDOCUME B
        where A. CODCLI = B.CODCLI and (A.CODCLI like '%V_0%' AND A.NOMCLI like '%V_1%') order by A.CODCLI";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','Nombre'),
		    100
		    );

	    return $catalogo;
	}

   	public static function catalogo_documentos($objhtml)
	{
		$sql="select distinct REFDOC as codigo, desdoc as descripcion from COBDOCUME WHERE STADOC='A' and (REFDOC like '%V_0%' AND desdoc like '%V_1%') order by REFDOC";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_tipoclientes($objhtml)
	{
		$sql="select distinct codtipcli as codigo, nomtipcte as descripcion from FATIPCTE where (CODTIPCLI like '%V_0%' AND nomtipcte like '%V_1%') order by CODTIPCLI";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	   	public static function catalogo_abono($objhtml)
	{
		$sql="select distinct  NUMTRA as codigo, DESTRA as descripcion from COBTRANSA WHERE STATUS='A' and (NUMTRA like '%V_0%' AND DESTRA like '%V_1%') order by NUMTRA";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}


	public static function catalogo_factura($objhtml)
	{
		$sql="select distinct REFFAC as factura from COBDOCUME where (REFFAC like '%V_0%') order by REFFAC";

		$catalogo = array(
		    $sql,
		    array('Factura'),
		    array($objhtml),
		    array('factura'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_abonoclientes($objhtml)
	{
		$sql="select distinct (A.CODCLI) as codigo, A.NOMCLI as nombre from cobclient A, COBTRANSA B
        where A.CODCLI=B.CODCLI AND (A.CODCLI like '%V_0%' AND A.NOMCLI like '%V_1%') order by A.CODCLI";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','Nombre'),
		    100
		    );

	    return $catalogo;
	}

	   	public static function catalogo_transaccion($objhtml)
	{
		$sql="select distinct NUMTRA as codigo, destra as descripcion from COBTRANSA where (NUMTRA like '%V_0%' AND destra like '%V_1%') order by NUMTRA";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}
      	public static function catalogo_movimiento($objhtml)
	{
		$sql="select distinct codmov as codigo, desmov as descripcion from COBTIPMOV where (codmov like '%V_0%' AND desmov like '%V_1%') order by codmov";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

   	public static function catalogo_tipomov($objhtml)
	{
		$sql="select  distinct codmov as codigo, desmov as descripcion from COBTIPMOV where (codmov like '%V_0%' AND desmov like '%V_1%') order by codmov";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

}

