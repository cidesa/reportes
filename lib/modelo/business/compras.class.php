<?php
require_once("../../lib/modelo/baseClases.class.php");

class Compras extends baseClases
{

 	public static function catalogo_codart($objhtml)
	{
	 $sql="select distinct(codart) as codigo, desart as descripción  from caregart where length(trim(codart))=(select (length(trim( forart))) from cadefart) and ( codart like '%V_0%' AND desart like '%V_1%' ) order by codart ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_codartg($objhtml)
	{
	 $sql="select distinct(codart) as codigo, desart as descripción  from caregart where ( codart like '%V_0%' AND desart like '%V_1%' ) order by codart ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_existencia($objhtml)
	{
	 $sql="SELECT distinct(exitot) as existencia FROM CAREGART order by exitot ";

		$catalogo = array(
		    $sql,
		    array('Existencia'),
		    array($objhtml),
		    array('existencia'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_codartd($objhtml)
	{
	 $sql="select distinct(a.codart) as codigo, b.desart as descripción  from caartdph a, caregart b where a.codart=b.codart and ( codart like '%V_0%' AND desart like '%V_1%' ) order by codart ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_coddes($objhtml)
	{
	 $sql="select distinct(a.dphart) as codigo, b.desdph as descripción  from caartdph a, dphart b where a.dphart=b.dphart and ( dphart like '%V_0%' AND desdph like '%V_1%' ) order by dphart ";


 		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_rcpart($objhtml)
	{
	 $sql="SELECT distinct(rcpart) as codigo, desrcp as descripción from carcpart where ( rcpart like '%V_0%' AND desrcp like '%V_1%' ) order by rcpart ";

		$catalogo = array(
		    $sql,
		    array('Codigo de Nota de Recepción','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_codpro($objhtml)
	{
	 $sql="select distinct(b.codpro) as codigo, b.nompro as nombre from caprovee b";

 		$catalogo = array(
		    $sql,
		    array('Codigo Del Proveedor','Nombre'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_codartr($objhtml)
	{
	 $sql="select distinct(a.codart) as codigo, b.desart as descripcion from caartrcp a, caregart b where a.codart=b.codart and ( a.codart like '%V_0%' AND b.desart like '%V_1%' ) order by codart ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_caordcom($objhtml)
	{
		$sql="Select distinct(ordcom) as orden, desord as descripcion from caordcom where ordcom like 'OC%' and ( ordcom like '%V_0%' AND desord like '%V_1%' ) order by ordcom";

		$catalogo = array(
		    $sql,
		    array('Codigo de Compra','Descripción'),
		    array($objhtml),
		    array('orden'),
		    450
		    );

	    return $catalogo;
	}
	
        
	public static function catalogo_ordenes($objhtml)
	{
		$sql="Select distinct(ordcom) as orden, desord as descripcion from caordcom where ( ordcom like '%V_0%' AND desord like '%V_1%' ) order by ordcom";

		$catalogo = array(
		    $sql,
		    array('Orden Compra/Servicio','Descripción'),
		    array($objhtml),
		    array('orden'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_caprovee($objhtml)
	{
	 $sql="select a.rifpro as rif, a.nompro as nombre from caprovee a where  (a.rifpro like '%V_0%' AND a.nompro like '%V_1%') order by a.rifpro   ";

 		$catalogo = array(
		    $sql,
		    array('RIF Del Proveedor','Nombre Proveedor'),
		    array($objhtml),
		    array('rif'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_casolart($objhtml)
	{
		$sql="SELECT DISTINCT(REQART) as codigo, desreq as Descripcion FROM CASOLART where  REQART like '%V_0%' and desreq like '%V_1%' order by REQART";

		$catalogo = array(
		    $sql,
		    array('Codigo de Requisicion','Descripcion'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_codalm($objhtml)
	{
	 $sql="select distinct(codalm) as codigo, nomalm as nombre from cadefalm where ( codalm like '%V_0%' AND nomalm like '%V_1%' ) order by codalm ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Almacen','Nombre'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_refcot($objhtml)
	{
	 	$sql="select distinct(refcot) as numero, descot as descripcion FROM cacotiza";

		$catalogo = array(
		    $sql,
		    array('Numero de Cotiza','Descripción'),
		    array($objhtml),
		    array('numero'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_caordcom_ordcom($objhtml)
	{
	 $sql="select (a.ordcom) as orden, to_char(a.fecord,'dd/mm/yyyy') as fecha   from carcpart c, caordcom a left join caprovee b on a.codpro=b.codpro  where A.ORDCOM=C.ORDCOM and (a.ordcom like '%V_0%' AND a.fecord like '%V_1%') order by a.ordcom ";

 		$catalogo = array(
		    $sql,
		    array('N° Orden','Fecha Orden'),
		    array($objhtml),
		    array('orden'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_caordcom_rifpro($objhtml)
	{
	 $sql="select distinct(a.codpro) as codigo, a.nompro as nompro from caprovee a, caordcom b where (a.codpro=b.codpro) and (a.codpro like '%V_0%' AND a.nompro like '%V_1%') order by a.codpro ";

 		$catalogo = array(
		    $sql,
		    array('Cod Del Proveedor','Nombre Proveedor'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}
        
              
        public static function catalogo_codcat($objhtml)
	{
		$sql="select distinct codcat as codigo,nomcat as nombre from npcatpre order by codcat ";

		$catalogo = array(
		    $sql,
		    array('Unidad Solicitante','Nombre Unidad'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

		return $catalogo;
	}
        
        public static function catalogo_codpar($objhtml)
	{
		$sql="SELECT DISTINCT(CODPAR) AS codigo, NOMPAR AS NOMBRE FROM NPPARTIDAS ORDER BY CODPAR";

		$catalogo = array(
		    $sql,
		    array('Codigo Partida','Nombre Partida'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

		return $catalogo;
	}

        
		public static function catalogo_coddes2($objhtml)
	{
	 $sql="select distinct(a.dphart) as codigo, b.desdph as descripcion  from caartdph a, cadphart b where a.dphart=b.dphart and ( a.dphart like '%V_0%' AND b.desdph like '%V_1%' )  order by a.dphart  ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Despacho','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_almc($objhtml)
	{
	 $sql="select distinct(codtra) as codigo , destra as descripcion from catraalm where ( codtra like '%V_0%' AND destra like '%V_1%' )  ";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}
	public static function catalogo_codartd2($objhtml)
	{
	 $sql="select distinct(a.codart) as codigo, b.desart as descripcion  from caartdph a, caregart b where a.codart=b.codart and ( a.codart like '%V_0%' AND b.desart like '%V_1%' )  order by a.codart ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Articulo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}


	public static function catalogo_codsal($objhtml)
	{
	 $sql="select distinct(codsal) as numero, dessal as descripcion  from casalalm where ( codsal like '%V_0%' AND upper(dessal) like '%V_1%' ) order by codsal ";

		$catalogo = array(
		    $sql,
		    array('Número de Salida','Descripción'),
		    array($objhtml),
		    array('numero'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_codprosal($objhtml)
	{
	 $sql="select distinct(codpro) as codigo, nompro as nombre  from caprovee  where ( codpro like '%V_0%' AND upper(nompro) like '%V_1%' )order by codpro ";

		$catalogo = array(
		    $sql,
		    array('Código del Proveedor','Nombre del Proveedor'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}
	public static function catalogo_ramart($objhtml)
	{
	 $sql="select distinct(ramart) as codigo, nomram as descripcion  from caramart  where ( ramart like '%V_0%' AND upper(nomram) like '%V_1%' )order by ramart ";

		$catalogo = array(
		    $sql,
		    array('Código del Ramo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_codent($objhtml)
	{
	 $sql="select distinct(rcpart) as numero, desrcp as descripcion  from caentalm where ( rcpart like '%V_0%' AND upper(desrcp) like '%V_1%' ) order by rcpart";

		$catalogo = array(
		    $sql,
		    array('Número de Entrada','Descripción'),
		    array($objhtml),
		    array('numero'),
		    450
		    );

	    return $catalogo;
	}


}
