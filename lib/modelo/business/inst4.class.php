<?php
require_once("../../lib/modelo/baseClases.class.php");
require_once("../../lib/general/Herramientas.class.php");

class inst4 extends baseClases
{
 	public static function catalogo_forcargos($objhtml)
	{
	 $sql="select distinct(codcar) as codcar, nomcar as nomcar from forcargos where ( codcar like '%V_0%' AND nomcar like '%V_1%' ) order by codcar ";

		$catalogo = array(
		    $sql,
		    array('Código Del Cargo','Descripción'),
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
		    array('Código Proyecto/Acción Centralizada'),
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
		    array('Código Del Programa'),
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
		    array('Código Del Actividad'),
		    array($objhtml),
		    array('act'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_forcargos_codtip($objhtml)
	{
	 $sql="select codtip as codigo, codcar as Cargo, nomcar as Descripcion from forcargos where ( codtip like '%V_0%' AND nomcar like '%V_1%' ) and codtip<>'' order by codcar ";

		$catalogo = array(
		    $sql,
		    array('Código','Cargo','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_npasicaremp_codnom($objhtml)
	{
	 $sql="select distinct a.codnom, b.nomnom from npasicaremp a, npnomina b where ( a.codnom like '%V_0%' and b. nomnom like '%V_1%' ) and a.codnom=b.codnom order by a.codnom ";

		$catalogo = array(
		    $sql,
		    array('Código Nómina','Descripción'),
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
		    array('Codigo Proyecto/Acción Centralizada','Denominación'),
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

	 public static function catalogo_oce0406($objhtml)
	{
		$sql="select cuenta as codigo, buscardescripcion('C',cuenta) as descripcion from forcfgrepins where nrofor='0406' and (cuenta like '%V_0%' AND descripcion like '%V_1%') order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Código de la Cuenta','Descripción de la Cuenta'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_codta0408($objhtml)
	{

		$sql="select cuenta from forcfgrepins where cuenta like '%V_0%' and nrofor = 0408 order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Nro de Cuenta'),
		    array($objhtml),
		    array('cuenta'),
		    100
		    );

	    return $catalogo;
	}

        public static function catalogo_codta0430($objhtml)
	{

		$sql="select cuenta as Codigo, buscardescripcion('I',cuenta) as descripcion from forcfgrepins where cuenta like '%V_0%' and descripcion like '%V_1%' and nrofor = '0430' order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Código de Cuenta','Descripción'),
		    array($objhtml),
		    array('Codigo'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_codta0431($objhtml)
	{

		$sql="select cuenta as Codigo, buscardescripcion('I',cuenta) as descripcion from forcfgrepins where cuenta like '%V_0%' and descripcion like '%V_1%' and nrofor = '0431' order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Código de Cuenta','Descripción'),
		    array($objhtml),
		    array('Codigo'),
		    100
		    );

	    return $catalogo;
	}
		 public static function catalogo_oce0425($objhtml)
	{
		$sql="select cuenta as codigo, buscardescripcion('C',cuenta) as descripcion from forcfgrepins where (cuenta like '%V_0%' AND descripcion like '%V_1%') and nrofor = '0425' order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Código de la Cuenta','Descripción de la Cuenta'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

			 public static function catalogo_oce0424($objhtml)
	{
		$sql="select cuenta as codigo, buscardescripcion('C',cuenta) as descripcion from forcfgrepins where (cuenta like '%V_0%' AND descripcion like '%V_1%') and nrofor = '0424' order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Código de la Cuenta','Descripción de la Cuenta'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}
 			 public static function catalogo_oce0409($objhtml)
	{
		$sql="select cuenta as codigo, buscardescripcion('C',cuenta) as descripcion from forcfgrepins where (cuenta like '%V_0%' AND descripcion like '%V_1%') and nrofor = '0409' order by cuenta";

		$catalogo = array(
		    $sql,
		    array('Código de la Cuenta','Descripción de la Cuenta'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}
	 	    public static function catalogo_codente($objhtml)
	{
		$sql="";

		$catalogo = array(
		    $sql,
		    array('Código del ente','Nombre del Ente'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}



}
?>