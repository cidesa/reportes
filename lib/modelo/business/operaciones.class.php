<?php
require_once("../../lib/modelo/baseClases.class.php");

class operaciones  extends baseClases{

//Catalogo de Tipo de Equipo
   function catalogo_ctipequ($objhtml)
    {
    	$sql="select DISTINCT codtip as codigo,destip as descripcion  from godeftipequ
        where (codtip like '%V_0%' AND destip  like '%V_1%' ) order by codtip";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
//Catalogo de Tipo de Estatus
   function catalogo_ctipest($objhtml)
    {
    	$sql="select DISTINCT codtes as codigo,destes as descripcion  from godeftipest
        where (codtes like '%V_0%' AND destes  like '%V_1%' ) order by codtes";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
  //Catalogo de Subipo de Estatus
   function catalogo_ccodsub($objhtml)
    {
    	$sql="select DISTINCT codsub as codigo,dessub as descripcion  from godefsubest
        where (codsub like '%V_0%' AND dessub  like '%V_1%' ) order by codsub";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
   //Catalogo de Estatus de Equipo
   function catalogo_ccodest($objhtml)
    {
    	$sql="select DISTINCT codest as codigo,desest as descripcion  from godefestequ
        where (codest like '%V_0%' AND desest  like '%V_1%' ) order by codest";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
    //Catalogo de Unidad de Medida
   function catalogo_ccoduni($objhtml)
    {
    	$sql="select DISTINCT coduni as codigo,nomuni as nombre  from godefunimed
        where (coduni like '%V_0%' AND nomuni  like '%V_1%' ) order by coduni";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    50
		    );

	    return $catalogo;
    }
     //Catalogo de Factores de Carga
   function catalogo_ccodfac($objhtml)
    {
    	$sql="select DISTINCT codfac as codigo,nomfac as nombre  from godeffaccar
        where (codfac like '%V_0%' AND nomfac  like '%V_1%' ) order by codfac";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    50
		    );

	    return $catalogo;
    }
     //Catalogo de Factores que afectan la Productividad
   function catalogo_ccodfacprod($objhtml)
    {
    	$sql="select DISTINCT codfac as codigo,desfac as descripcion  from godeffacpro
        where (codfac like '%V_0%' AND desfac  like '%V_1%' ) order by codfac";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
      //Catalogo de Condiciones de Productividad
   function catalogo_ccodcon($objhtml)
    {
    	$sql="select DISTINCT codcon as codigo,descon as descripcion  from godefconpro
        where (codcon like '%V_0%' AND descon  like '%V_1%' ) order by codcon";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
      //Catalogo de Procedencia del Equipo
   function catalogo_ccodpro($objhtml)
    {
    	$sql="select DISTINCT codpro as codigo,despro as descripcion  from godefproequ
        where (codpro like '%V_0%' AND despro  like '%V_1%' ) order by codpro";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
   //Catalogo de  Equipo
   function catalogo_ccodequ($objhtml)
    {
    	$sql="select DISTINCT codequ as codigo,modequ as modelo  from godefequipo
        where (codequ like '%V_0%' AND modequ  like '%V_1%' ) order by codequ";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Modelo'),
		    array($objhtml),
		    array('codigo','modelo'),
		    50
		    );

	    return $catalogo;
    }
    //Catalogo de  Estatus del Radio
   function catalogo_ccodrad($objhtml)
    {
    	$sql="select DISTINCT codrad as codigo,desrad as descripcion  from Godefstarad
        where (codrad like '%V_0%' AND desrad  like '%V_1%' ) order by codrad";

		 $catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    50
		    );

	    return $catalogo;
    }
      //Catalogo de  Vehiculos Livianos
   function catalogo_cplaveh($objhtml)
    {
    	$sql="select DISTINCT plaveh as placa,modveh as modelo  from Godefveh
        where (plaveh like '%V_0%' AND modveh  like '%V_1%' ) order by plaveh";

		 $catalogo = array(
		    $sql,
		    array('Placa','Modelo'),
		    array($objhtml),
		    array('placa','modveh'),
		    50
		    );

	    return $catalogo;
    }
}
?>