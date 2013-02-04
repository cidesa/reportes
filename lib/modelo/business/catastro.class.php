<?php
require_once("../../lib/modelo/baseClases.class.php");

class catastro extends baseClases
{
		public static function catalogo_vial($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,desdir as descripcion from catdirvia
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND desdir like '%V_1%' ) order by codigo";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

		public static function catalogo_senvial($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,dessen as descripcion from catsenvia
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND dessen like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

			public static function catalogo_tipvial($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,desvia as descripcion from cattipvia
        where (to_char(id,'9999999999999999999999999')  like '%V_0%' AND desvia like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

           public static function catalogo_coninmuebles($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,desconinm as descripcion from catconinm
        where (to_char(id,'9999999999999999999999999')  like '%V_0%' AND desconinm like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

    public static function catalogo_carconst($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,nomcarcon as descripcion from catcarcon
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND nomcarcon like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

	public static function catalogo_carterreno($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,dester as descripcion from catcarter
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND dester like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

	public static function catalogo_condicion($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,desconsoc as descripcion from catconsoc
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND desconsoc like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

	public static function catalogo_postal($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,despos as descripcion from catcodpos
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND despos like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

	public static function catalogo_viviendas($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,destipviv as descripcion from cattipviv
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND destipviv like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}
	public static function catalogo_uso($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,desuso as descripcion from catusoesp
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND desuso like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

		public static function catalogo_proterreno($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,descatproter as descripcion from catproter
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND descatproter like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

	public static function catalogo_territorio($objhtml)
	{
		$sql="select DISTINCT (coddivgeo) as codigo,desdivgeo as descripcion from catdivgeo
        where (coddivgeo like '%V_0%' AND desdivgeo like '%V_1%' ) order by coddivgeo";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

	public static function catalogo_persona($objhtml)
	{
		$sql="select DISTINCT (id) as codigo,nomper as nombre from catregper
        where (to_char(id,'9999999999999999999999999') like '%V_0%' AND nomper like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','nombre'),
		    50
		    );

	    return $catalogo;
	}

  	public static function catalogo_codubigeog($objhtml)
	{

		$sql="select DISTINCT coddivgeo as codigo,desdivgeo as descripcion  from catdivgeo
        where (coddivgeo like '%V_0%' AND desdivgeo  like '%V_1%' AND  length(coddivgeo)= 14) order by coddivgeo";

                $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}
        public static function catalogo_codtramo($objhtml)
	{

		$sql="select DISTINCT coddivgeo as codigo,desdivgeo as descripcion  from catdivgeo
        where (coddivgeo like '%V_0%' AND desdivgeo  like '%V_1%' AND length(coddivgeo)= 17) order by coddivgeo";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

          public static function catalogo_ccatastral($objhtml)
	{

		$sql="select DISTINCT coddivgeo as codigo,desdivgeo as descripcion  from catdivgeo
        where (coddivgeo like '%V_0%' AND desdivgeo  like '%V_1%' AND length(coddivgeo)= 17) order by coddivgeo";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
	}

}
?>
