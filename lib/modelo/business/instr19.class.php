<?php
require_once("../../lib/modelo/baseClases.class.php");
require_once("../../lib/general/Herramientas.class.php");

class instr19 extends baseClases
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
	 $sql="select distinct(substr(codcat,1,2)) as proacc from fordefcatpre where ( substr(codcat,1,2) like '%V_0%' ) order by substr(codcat,1,2) ";

		$catalogo = array(
		    $sql,
		    array('Codigo Proyecto/Accion Centralizada'),
		    array($objhtml),
		    array('proacc'),
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
	
	public static function catalogo_forcargos_codtip($objhtml)
	{
	 $sql="select distinct(codtipcar) as codcar, destipcar as nomcar from nptipcar where ( codtipcar like '%V_0%' AND destipcar like '%V_1%' ) order by codtipcar ";

		$catalogo = array(
		    $sql,
		    array('Codigo Del Tipo Cargo','Descripción'),
		    array($objhtml),
		    array('codcar'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_npasicaremp_codnom($objhtml)
	{
	 $sql="select distinct a.codnom, b.nomnom from npasicaremp a, npnomina b where ( a.codnom like '%V_0%' and b. nomnom like '%V_1%' ) and a.codnom=b.codnom order by a.codnom ";

		$catalogo = array(
		    $sql,
		    array('Codigo Nomina','Descripcion'),
		    array($objhtml),
		    array('codnom'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_cpdeftit_proacc($objhtml)
	{
	 $sql="select distinct(substr(codpre,1,2)) as proacc  from cpdeftit where ( substr(codpre,1,2) like '%V_0%' ) order by substr(codpre,1,2) ";

		$catalogo = array(
		    $sql,
		    array('Codigo Proyecto/Accion Centralizada','Denominacion'),
		    array($objhtml),
		    array('proacc'),
		    100
		    );

	    return $catalogo;
	}
	
  public static function catalogo_codprePrerasiini_accesp($objhtml)
  {
   $sql="select substr(codpre,1,5) as codpre,
   (select nompre from cpdeftit where codpre=rpad(substr(a.codpre,1,5),50,' ')) as nompre 
   from cpdeftit a where ( substr(codpre,1,5) like '%V_0%' ) and length(trim(codpre))<=5 order by codpre";


    $catalogo = array(
        $sql,
        array('Código Presupuestario','Nombre'),
        array($objhtml),
        array('codpre'),
        100
        );

      return $catalogo;
  }
  
     public static function catalogo_partidas($objhtml)
	{
		$arr = H::inifinpar();
		$sql="select distinct substr(ca.odpre,".$arr[0][0].",".($arr[0][1]-$arr[0][0]).") as codpar  from cpdeftit where ( substr(a.codpre,".$arr[0][0].",".($arr[0][1]-$arr[0][0]).") like '%V_0%'  ) and trim(substr(a.codpre,".$arr[0][0].",".($arr[0][1]-$arr[0][0])."))<>'' order by codpar";

		$catalogo = array(
		    $sql,
		    array('PARTIDA'),
		    array($objhtml),
		    array('codpar'),
		    100
		    );

	    return $catalogo;
	}
}
?>