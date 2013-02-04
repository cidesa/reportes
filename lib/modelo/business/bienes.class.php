<?php
require_once("../../lib/modelo/baseClases.class.php");

class bienes  extends baseClases{



     function ObtenerUbicacion($alias,$codubi)
    {


    	$sql="SELECT desubi as nomabr, forubi as lonniv FROM bndefins";

       $arrniveles=$this->select($sql);

    $a=0;
    $acupos=1;
    $cadena="";
    //strlen($arrniveles[0]['lonniv']);
    $a=explode('-',$arrniveles[0]['lonniv']);
    $b=explode('-',$arrniveles[0]['nomabr']);
    $l=count($a);
  	 for ($i = 0; $i < $l; $i++) {
     $lon= strlen($a[$i]);
     if ($a==0) $pripos=1;  else $pripos=$acupos;
     $acupos=$acupos+$lon+1;
     $cadena=$cadena." substr(".$alias.".".$codubi.",".$pripos.",".$lon.") as ".$b[$i].",";
     $a++;
 		}


    $cadena=substr($cadena,0,strlen($cadena)-1);
    return $cadena;


    }

    public static function catalogo_codact($objhtml)
	{
		$sql="SELECT distinct(a.codact) as cod, b.desact as des FROM bnregmue a, bndefact b where a.codact = b.codact and ( a.codact like '%V_0%' AND b.desact like '%V_1%' ) ORDER BY a.codact";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Activo','Descripción'),
		    array($objhtml),
		    array('cod'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_codmue($objhtml)
	{
	   $sql="SELECT DISTINCT(codmue) as codmue, desmue FROM bnregmue where ( codmue like '%V_0%' AND desmue like '%V_1%' ) order by codmue";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Bien','Descripción'),
		    array($objhtml),
		    array('codmue'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_codubi($objhtml)
	{
	   $sql="SELECT DISTINCT(a.codubi) as codubi, b.desubi FROM bnregmue a, bnubibie b where a.codubi=b.codubi and ( codmue like '%V_0%' AND desmue like '%V_1%' ) order by a.codubi";

		$catalogo = array(
		    $sql,
		    array('Codigo De Ubicacion','Descripción'),
		    array($objhtml),
		    array('codubi'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_codinm($objhtml)
	{
	   $sql="SELECT DISTINCT(codinm) as codinm, desinm FROM bnreginm where ( codinm like '%V_0%' AND desinm like '%V_1%' ) order by codinm";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Bien','Descripción'),
		    array($objhtml),
		    array('codinm'),
		    100
		    );

	    return $catalogo;
	}

	//select distinct(codemp) as codemp,nomemp, nomcar from npasicaremp where ( nomcar like '%DIR%' OR nomcar like '%JEF%' )

	public static function catalogo_codemp($objhtml)
	{
		$sql="select distinct(codemp) as Codigo ,nomemp , nomcar as Cargo from npasicaremp where ( (nomcar like '%DIR%' OR nomcar like '%JEF%') AND codemp like '%V_0%' AND  nomemp like '%V_1%' AND nomcar like '%V_2%' ) order by codemp";

		$catalogo = array(
		    $sql,
		    array('Codigo Empleado','Apellido','Cargo del Empleado'),
		    array($objhtml),
		    array('nomemp'),
		    100
		    );

	    return $catalogo;
	}	
	
	public static function catalogo_bndisbie_coddis($objhtml)
	{
		$sql="select distinct(coddis) as Codigo ,desdis as Descripcion from bndisbie where ( coddis  like '%V_1%' AND desdis like '%V_2%' ) order by coddis";

		$catalogo = array(
		    $sql,
		    array('Codigo Empleado','Apellido','Cargo del Empleado'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

		 function catalogo_bnubibie($objhtml)
    {
    	$sql="select codubi as codigo, desubi as nombre from bnubibie where length(trim(codubi))=(select max(length(trim(codubi))) from bnubibie) and ( codubi like '%V_0%' AND desubi like '%V_1%' ) order by codubi";

		$catalogo = array(
		    $sql,
		    array('Codigo De Ubicacion','Nombre'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
    }

	    function catalogo_municipio($objhtml)
    {
    	$sql="select nommun as nombre from ocmunici";

		$catalogo = array(
		    $sql,
		    array('Parroquia'),
		    array($objhtml),
		    array('nombre'),
		    100
		    );

	    return $catalogo;
    }

	    function catalogo_parroquia($objhtml)
    {
    	$sql="select nompar as nombre from ocparroq";

		$catalogo = array(
		    $sql,
		    array('Parroquia'),
		    array($objhtml),
		    array('nombre'),
		    100
		    );

	    return $catalogo;
    }

}
?>