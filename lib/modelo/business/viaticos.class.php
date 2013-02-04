<?php
require_once("../../lib/modelo/baseClases.class.php");

class Viaticos extends baseClases
{
/**
 *   REPORTE::tsrdisban.php
 *
 * */

 	public static function catalogo_codrub($objhtml)
	{
		$sql="SELECT distinct(codrub) as codrub, desrub from viadefrub where ( codrub like '%V_0%' AND desrub like '%V_1%' ) order by codrub";
		$catalogo = array(
		    $sql,
		    array('codigo','Rubro'),
		    array($objhtml),
		    array('codrub'),
		    100
		    );
	    return $catalogo;
	}
        public static function catalogo_codniv($objhtml)
	{
		$sql="SELECT distinct(codniv) as codniv, desniv from viadefniv where ( codniv like '%V_0%' AND desniv like '%V_1%' ) order by codniv";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nivel(Rango Trabajador)'),
		    array($objhtml),
		    array('codniv'),
		    100
		    );
	    return $catalogo;
	}
        public static function catalogo_codtiptra($objhtml)
	{
		$sql="SELECT distinct(codtiptra) as codtiptra, destiptra from viadeftiptra where ( codtiptra like '%V_0%' AND destiptra like '%V_1%' ) order by codtiptra";
		$catalogo = array(
		    $sql,
		    array('Codigo','Tipos Traslados'),
		    array($objhtml),
		    array('codtiptra'),
		    100
		    );
	    return $catalogo;
	}
        public static function catalogo_codfortra($objhtml)
	{
		$sql="SELECT distinct(codfortra) as codfortra, desfortra from viadeffortra where ( codfortra like '%V_0%' AND desfortra like '%V_1%' ) order by codfortra";
		$catalogo = array(
		    $sql,
		    array('Codigo','Formas de Traslados'),
		    array($objhtml),
		    array('codfortra'),
		    100
		    );
	    return $catalogo;
	}
        public static function catalogo_codnivapr($objhtml)
	{
		$sql="SELECT distinct(codnivapr) as codnivapr, desnivapr from viadefnivapr where ( codnivapr like '%V_0%' AND desnivapr like '%V_1%' ) order by codnivapr";
		$catalogo = array(
		    $sql,
		    array('Codigo','Niveles de Aprobación'),
		    array($objhtml),
		    array('codnivapr'),
		    100
		    );
	    return $catalogo;
	}
        public static function catalogo_codproced($objhtml)
	{
		$sql="SELECT distinct(codproced) as codproced, desproced from viadefproced where ( codproced like '%V_0%' AND desproced like '%V_1%' ) order by codproced";
		$catalogo = array(
		    $sql,
		    array('Codigo','Procedencias'),
		    array($objhtml),
		    array('codproced'),
		    100
		    );
	    return $catalogo;
	}
        public static function catalogo_codemp($objhtml)
	{
		$sql="select distinct(codemp) as codemp,nomemp from npasicaremp where ( codemp like '%V_0%' AND nomemp like '%V_1%' ) order by codemp";

		$catalogo = array(
		    $sql,
		    array('Codigo Empleado','Nombre Empleado'),
		    array($objhtml),
		    array('codemp'),
		    100
		    );

	    return $catalogo;
	}
        public static function catalogo_codcat($objhtml)
	{
		$sql="select distinct rtrim(codcat) as codcat,nomcat from npcatpre order by rtrim(codcat)";

		$catalogo = array(
		    $sql,
		    array('Codigo Categoria','Nombre Categoria'),
		    array($objhtml),
		    array('codcat'),
		    100
		    );

		return $catalogo;
	}
        public static function catalogo_codciu($objhtml)
	{
		$sql="select distinct rtrim(codciu) as codciu,nomciu from viaciudad order by rtrim(codciu)";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre Ciudad'),
		    array($objhtml),
		    array('codciu'),
		    100
		    );

		return $catalogo;
	}
        public static function catalogo_numsol($objhtml)
	{
		$sql="select distinct rtrim(numsol) as numsol,fecsol from viasolviatra order by rtrim(numsol)";

		$catalogo = array(
		    $sql,
		    array('Número','Fecha'),
		    array($objhtml),
		    array('numsol'),
		    100
		    );

		return $catalogo;
	}
        public static function catalogo_numcal($objhtml)
	{
		$sql="select distinct rtrim(numcal) as numcal,feccal from viacalviatra order by rtrim(numcal)";

		$catalogo = array(
		    $sql,
		    array('Número','Fecha'),
		    array($objhtml),
		    array('numcal'),
		    100
		    );

		return $catalogo;
	}
        public static function catalogo_numrel($objhtml)
	{
		$sql="select distinct rtrim(numrel) as numrel,fecrel from viarelvia order by rtrim(numrel)";

		$catalogo = array(
		    $sql,
		    array('Número','Fecha'),
		    array($objhtml),
		    array('numrel'),
		    100
		    );

		return $catalogo;
	}
        public static function catalogo_codpar($objhtml)
	{
		$sql="select distinct rtrim(codpar) as codpar,nompar from nppartidas order by rtrim(codpar)";

		$catalogo = array(
		    $sql,
		    array('Codigo Partida','Nombre Partida'),
		    array($objhtml),
		    array('codpar'),
		    100
		    );

		return $catalogo;
	}

}

