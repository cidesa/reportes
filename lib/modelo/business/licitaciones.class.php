<?php
require_once("../../lib/modelo/baseClases.class.php");

class licitaciones extends baseClases{
    
    public static function catalogo_liprebas_numpre($objhtml)
	{
	   $sql="SELECT DISTINCT(numpre) as numpre, to_char(fecreg,'dd/mm/yyy') as fecreg FROM liprebas where ( numpre like '%V_0%' ) and (tipconpub='B' or tipconpub is null) order by numpre";

		$catalogo = array(
		    $sql,
		    array('Nro. Presupuesto','Fecha Registro'),
		    array($objhtml),
		    array('numpre'),
		    100
		    );

	    return $catalogo;
	}
        
        public static function catalogo_limemoran_numemo($objhtml)
	{
	   $sql="SELECT DISTINCT(numemo) as numemo, to_char(fecreg,'dd/mm/yyy') as fecreg FROM limemoran where ( numemo like '%V_0%' ) and (tipconpub='B' or tipconpub is null) order by numemo";

		$catalogo = array(
		    $sql,
		    array('Nro. Memorando','Fecha Registro'),
		    array($objhtml),
		    array('numemo'),
		    100
		    );

	    return $catalogo;
	}
        
        public static function catalogo_liptocue_numptocue($objhtml)
	{
	   $sql="SELECT DISTINCT(numptocue) as numptocue, to_char(fecreg,'dd/mm/yyy') as fecreg FROM liptocue where ( numptocue like '%V_0%' ) and (tipconpub='B' or tipconpub is null) order by numptocue";

		$catalogo = array(
		    $sql,
		    array('Nro. Pto de Cuenta','Fecha Registro'),
		    array($objhtml),
		    array('numptocue'),
		    100
		    );

	    return $catalogo;
	}
        
        public static function catalogo_lisolegr_numsol($objhtml)
	{
	   $sql="SELECT DISTINCT(numsol) as numsol, to_char(fecreg,'dd/mm/yyy') as fecreg FROM lisolegr where ( numsol like '%V_0%' ) and (tipconpub='B' or tipconpub is null) order by numsol";

		$catalogo = array(
		    $sql,
		    array('Nro. Solicitud','Fecha Registro'),
		    array($objhtml),
		    array('numsol'),
		    100
		    );

	    return $catalogo;
	}
        
        public static function catalogo_licomint_numcomint($objhtml)
	{
	   $sql="SELECT DISTINCT(numcomint) as numcomint, to_char(fecreg,'dd/mm/yyy') as fecreg FROM Licomint where ( numcomint like '%V_0%' )  order by numcomint";

		$catalogo = array(
		    $sql,
		    array('Nro. Compra Integral','Fecha Registro'),
		    array($objhtml),
		    array('numcomint'),
		    100
		    );

	    return $catalogo;
	}
        
}