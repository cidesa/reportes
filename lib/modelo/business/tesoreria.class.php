<?php
require_once("../../lib/modelo/baseClases.class.php");

class Tesoreria extends baseClases
{
/**
 *   REPORTE::tsrdisban.php
 *
 * */

 	public static function catalogo_numcue($objhtml)
	{
		$sql="SELECT distinct(numcue) as numcue, nomcue from tsdefban where ( numcue like '%V_0%' AND nomcue like '%V_1%' ) order by numcue";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cuenta','Nombre Cuenta'),
		    array($objhtml),
		    array('numcue'),
		    100
		    );

	    return $catalogo;
	}


 	public static function catalogo_tipmov($objhtml)
	{
		$sql="SELECT DISTINCT(codtip) as codtip, destip FROM tstipmov  where ( codtip like '%V_0%' AND destip like '%V_1%' ) order by codtip";

		$catalogo = array(
		    $sql,
		    array('Código Tipo','Descripción'),
		    array($objhtml),
		    array('codtip'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_reflib($objhtml)
	{
		$sql="SELECT DISTINCT(reflib) as reflib, deslib as CODIGO FROM tsmovlib where ( reflib like '%V_0%' AND deslib like '%V_1%' ) ORDER BY reflib";

		$catalogo = array(
		    $sql,
		    array('Referencia','Descripción'),
		    array($objhtml),
		    array('reflib'),
		    100
		    );

	    return $catalogo;
	}

    public static function catalogo_banco($objhtml)
	{
		$sql="SELECT distinct(nomcue) as nomcue from tsdefban order by nomcue";

		$catalogo = array(
		    $sql,
		    array('Nombre Banco'),
		    array($objhtml),
		    array('nomcue'),
		    100
		    );

	    return $catalogo;
	}

   public static function catalogo_origen($objhtml)
	{
		$sql="SELECT distinct(ctaori) as ctaori from tsmovtra order by ctaori";

		$catalogo = array(
		    $sql,
		    array('N° Cuenta Origen'),
		    array($objhtml),
		    array('ctaori'),
		    100
		    );

	    return $catalogo;
	}


	public static function catalogo_benefi($objhtml)
	{
		$sql="select distinct(cedrif) as cedrif, nomben from OPBENEFI where ( cedrif like '%V_0%' AND nomben like '%V_1%' ) order by cedrif";
		$catalogo = array(
		    $sql,
		    array('Ced/Rif','Nombre Beneficiario'),
		    array($objhtml),
		    array('cedrif'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_numordpag($objhtml)
	{
		$sql="SELECT distinct(numord) as numero, desord as Descripcion FROM OPORDPAG where ( numord like '%V_0%') and ( desord like '%V_1%') ORDER BY NUMORD";
		$catalogo = array(
		    $sql,
		    array('Nro. de Orden','Descripcion'),
		    array($objhtml),
		    array('numero'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_tscheemi_numche($objhtml)
	{
		$sql="SELECT distinct(numche) as cheques from tscheemi where ( numche like '%V_0%' ) order by numche";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cheques'),
		    array($objhtml),
		    array('cheques'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_numcue_tscheemi($objhtml)
	{
		$sql="SELECT distinct(a.numcue) as numcue, b.nomcue from tscheemi a,tsdefban b where trim(a.numcue)=trim(b.numcue) and ( a.numcue like '%V_0%' AND b.nomcue like '%V_1%' ) order by a.numcue";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cuenta','Nombre Cuenta'),
		    array($objhtml),
		    array('numcue'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_tipdoc($objhtml)
	{
		$sql="SELECT distinct(tipdoc) as tipdoc from tscheemi where ( tipdoc like '%V_0%'  ) order by tipdoc";
		$catalogo = array(
		    $sql,
		    array('Tipo Documento'),
		    array($objhtml),
		    array('tipdoc'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_tscheemi_numche_v2($objhtml)
	{
		$sql="SELECT distinct(substr(numche,1,4)) as cheques from tscheemi where ( numche like '%V_0%' ) order by substr(numche,1,4)";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cheques'),
		    array($objhtml),
		    array('cheques'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_numcue_tsconcil($objhtml)
	{
		$sql="SELECT distinct(numcue) as numcue from tsconcil where ( numcue like '%V_0%' ) order by numcue";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cuenta'),
		    array($objhtml),
		    array('numcue'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_numordpag_opdisfue($objhtml)
	{
		$sql="SELECT distinct(a.numord) as numero, a.desord as Descripcion FROM OPORDPAG a, opdisfue b where trim(a.numord)=trim(b.numord) and ( a.numord like '%V_0%') and ( a.desord like '%V_1%') ORDER BY a.NUMORD";
		$catalogo = array(
		    $sql,
		    array('Nro. de Orden','Descripcion'),
		    array($objhtml),
		    array('numero'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_opdisfue_fuefin($objhtml)
	{
		$sql="SELECT  distinct a.codfin as TIPO, a.nomext as NOMBRE from fortipfin a left outer join opdisfue b on (trim(a.codfin)=trim(b.fuefin))  where  ( a.codfin like '%V_0%') and ( a.nomext like '%V_1%') ORDER BY a.codfin";
		$catalogo = array(
		    $sql,
		    array('Codigo Financiamiento','Nombre'),
		    array($objhtml),
		    array('tipo'),
		    100
		    );

	    return $catalogo;
	}

	////////////// NUEVOS PARA EL BASE

		public static function catalogo_tipcuenta($objhtml)
	{
		$sql="SELECT  distinct codtip as codigo,destip as descripcion from tstipcue where  ( codtip like '%V_0%' and destip like '%V_1%') ORDER BY codtip";
		$catalogo = array(
		    $sql,
		    array('TIPO','DESCRIPCION'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_numche_tscheemi($objhtml)
	{
		$sql="SELECT distinct(numche) as numche, fecemi from tscheemi where ( numche like '%V_0%' AND fecemi like '%V_1%' ) order by numche";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cheque','Fecha Cheque'),
		    array($objhtml),
		    array('numche'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_tsentislr_numdep($objhtml)
	{
		$sql="SELECT distinct(numdep) as deposito, banco  FROM TSENTISLR where ( numdep like '%V_0%') and ( banco like '%V_1%')  ORDER BY numdep";
		$catalogo = array(
		    $sql,
		    array('Nro Deposito','Banco'),
		    array($objhtml),
		    array('deposito'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_benefi_opordpag($objhtml)
	{
		$sql="select distinct(a.cedrif) as cedrif, a.nomben from OPORDPAG a where ( a.cedrif like '%V_0%' AND a.nomben like '%V_1%' ) order by a.cedrif";
		$catalogo = array(
		    $sql,
		    array('Ced/Rif','Nombre Beneficiario'),
		    array($objhtml),
		    array('cedrif'),
		    100
		    );

	    return $catalogo;
	}
		public static function catalogo_tsmovtra_reftra($objhtml)
	{
		$sql="SELECT distinct(a.reftra) as referencia, a.destra as Descripcion FROM TSMOVTRA a where ( a.reftra like '%V_0%') and ( a.destra like '%V_1%') ORDER BY a.reftra";
		$catalogo = array(
		    $sql,
		    array('Referencia','Descripcion'),
		    array($objhtml),
		    array('referencia'),
		    100
		    );

	    return $catalogo;
	}



               public static function catalogo_numord_ordpag($objhtml)
	{
		//$sql="select distinct(NUMORD) as Numero from OPORDPAG order by NUMORD";
		$sql="select distinct(a.NUMORD) as numord, a.nomben from OPORDPAG a where ( a.NUMORD like '%V_0%' AND a.nomben like '%V_1%' ) order by a.NUMORD";
                $catalogo = array(
		    $sql,
		    array('NUMORD','Numero de Orden de Pago'),
		    array($objhtml),
		    array('numord'),
		    100
		    );

	    return $catalogo;
	}


               public static function catalogo_codpre($objhtml)
	{
		$sql="select distinct(codpre) as codpre from cpimpcau a where ( codpre like '%V_0%' ) order by codpre";
                $catalogo = array(
		    $sql,
		    array('CODPRE','Codigo de Presupuestario'),
		    array($objhtml),
		    array('codpre'),
		    100
		    );

	    return $catalogo;
	}


        public static function catalogo_tipo_orden($objhtml)
	{

		$sql="SELECT DISTINCT(tipcau) as tip,numord FROM opordpag ORDER BY tipcau DESC";
		$catalogo = array(
		    $sql,
		    array('TIPCAU','Tipo de Orden'),
		    array($objhtml),
		    array('tip'),
		    100
		    );

	    return $catalogo;
	}


}
