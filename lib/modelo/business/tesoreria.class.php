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
		$sql="SELECT distinct(numcue) as número, nomcue as nombre from tsdefban where ( numcue like '%V_0%' AND nomcue like '%V_1%' ) order by numcue";
		$catalogo = array(
		    $sql,
		    array('Nro. de Cuenta','Nombre Cuenta'),
		    array($objhtml),
		    array('número'),
		    450
		    );
	    return $catalogo;
	}


 	public static function catalogo_tipmov($objhtml)
	{
		$sql="SELECT DISTINCT(codtip) as codigo, destip as descripcion FROM tstipmov  where ( codtip like '%V_0%' AND destip like '%V_1%' ) order by codtip";

		$catalogo = array(
		    $sql,
		    array('Código Tipo}','Descripción'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_reflib($objhtml)
	{
		$sql="SELECT DISTINCT(reflib) as referencia, deslib as descripcion FROM tsmovlib where ( reflib like '%V_0%' AND deslib like '%V_1%' ) ORDER BY reflib";

		$catalogo = array(
		    $sql,
		    array('Referencia','Descripción'),
		    array($objhtml),
		    array('referencia'),
		    450
		    );

	    return $catalogo;
	}
        
        public static function catalogo_reflibint($objhtml)
	{
		$sql="SELECT DISTINCT(reflib) as referencia, deslib as descripcion FROM tsmovlib where ( reflib like '%V_0%' AND deslib like '%V_1%' ) and valmon<>1 and valmon<>0 ORDER BY reflib";

		$catalogo = array(
		    $sql,
		    array('Referencia','Descripción'),
		    array($objhtml),
		    array('referencia'),
		    450
		    );

	    return $catalogo;
	}

    public static function catalogo_banco($objhtml)
	{
		$sql="SELECT distinct(nomcue) as nombre from tsdefban order by nomcue";

		$catalogo = array(
		    $sql,
		    array('Nombre Banco'),
		    array($objhtml),
		    array('nombre'),
		    450
		    );

	    return $catalogo;
	}

   public static function catalogo_origen($objhtml)
	{
		$sql="SELECT distinct(ctaori) as cuenta from tsmovtra order by ctaori";

		$catalogo = array(
		    $sql,
		    array('N° Cuenta Origen'),
		    array($objhtml),
		    array('cuenta'),
		    450
		    );

	    return $catalogo;
	}


	public static function catalogo_benefi($objhtml)
	{
		$sql="select distinct(cedrif) as cédula, nomben as nombre from OPBENEFI where ( cedrif like '%V_0%' AND nomben like '%V_1%' ) order by cedrif";
		$catalogo = array(
		    $sql,
		    array('Ced/Rif','Nombre Beneficiario'),
		    array($objhtml),
		    array('cédula'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_numordpag($objhtml)
	{
		$sql="SELECT distinct numord as número, nomben as nombre , to_char(FECEMI,'dd/mm/yyyy')  as fecha FROM opordpag where ( numord like '%V_0%' AND nomben like '%V_1%'  ) ORDER BY (NUMORD) ASC";
		$catalogo = array(
		    $sql,
		    array('Num. de Orden','Proveedor','Fecha'),
		    array($objhtml),
		    array('número'),
		    450
		    );

	    return $catalogo;
	}

		public static function catalogo_numcue_tscheemi($objhtml)
	{
		$sql="SELECT distinct(a.numcue) as número, b.nomcue  as cuenta from tsmovlib a,tsdefban b where trim(a.numcue)=trim(b.numcue) and ( a.numcue like '%V_0%' AND b.nomcue like '%V_1%' ) order by a.numcue";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cuenta','Nombre Cuenta'),
		    array($objhtml),
		    array('número'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_numche_tscheemi($objhtml)
	{
		$sql="SELECT distinct(a.numche) as número, to_char(a.fecemi,'dd/mm/yyyy') as fecha ,b.nomben as Nombre from tscheemi a, opbenefi b where ( a.numche like '%V_0%' AND to_char(a.fecemi,'dd/mm/yyyy') like '%V_1%'  ) and  a.cedrif=b.cedrif order by a.numche";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cheque','Fecha Cheque'),
		    array($objhtml),
		    array('número'),
		    450
		    );

	    return $catalogo;
	}


	public static function catalogo_tipdoc($objhtml)
	{
		$sql="SELECT distinct(tipdoc) as tipo from tscheemi where ( tipdoc like '%V_0%'  ) order by tipdoc";
		$catalogo = array(
		    $sql,
		    array('Tipo Documento'),
		    array($objhtml),
		    array('tipo'),
		    450
		    );

	    return $catalogo;
	}

	/**********PRUEBA*****************/
		public static function catalogo_codnom($objhtml)
	{
		$sql="select codnom as codigo, nomnom as nombre from npnomina where ( codnom like '%V_0%' and nomnom like '%V_1%'  ) order by codnom";
		$catalogo = array(
		    $sql,
		    array('Codigo de la Nomina','Nombre de la Nomina'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}

	/********************************/

	public static function catalogo_numfactura_opfactur($objhtml)
	{
		$sql="select numfac as número from opfactur where ( numfac like '%V_0%' ) order by numfac";
		$catalogo = array(
		    $sql,
		    array('Codigo de la Nomina','Nombre de la Nomina'),
		    array($objhtml),
		    array('número'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_benefi_opordpag($objhtml)
	{
		$sql="select distinct(a.cedrif) as cédula, a.nomben as nombre from OPBENEFI a, OPORDPAG b where a.cedrif=b.cedrif and ( a.cedrif like '%V_0%' AND a.nomben like '%V_1%' ) order by a.cedrif";
		$catalogo = array(
		    $sql,
		    array('Ced/Rif','Nombre Beneficiario'),
		    array($objhtml),
		    array('cédula'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_refmovcajchc($objhtml)
	{
		$sql="SELECT distinct(refsal) as codigo, dessal as nombre from tssalcaj where ( refsal like '%V_0%' AND dessal like '%V_1%' ) order by refsal";
		$catalogo = array(
		    $sql,
		    array('Referencia','Descripción'),
		    array($objhtml),
		    array('codigo','nombre'),
		    450
		    );
	    return $catalogo;
	}
		public static function catalogo_tscheemi_numche($objhtml)
	{
		$sql="SELECT distinct(a.numche) as cheques, a.numcue, b.nomcue from tscheemi a, tsdefban b where a.numcue=b.numcue and ( a.numche like '%V_0%' and a.numcue like '%V_1%' and b.nomcue  like '%V_2%' ) order by a.numche";

		$catalogo = array(
		    $sql,
		    array('Nro. de Cheques','Nro. Cuenta','Nombre Banco'),
		    array($objhtml),
		    array('cheques'),
		    450
		    );

	    return $catalogo;
	}
	 	public static function catalogo_benche($objhtml)
	{
		$sql="SELECT distinct (trim(a.CEDRIF)) as cédula, b.nomben as nombre FROM tscheemi a, opbenefi b where a.cedrif=b.cedrif and ( a.CEDRIF like '%V_0%') and ( b.nomben like '%V_1%')";

		$catalogo = array(
		    $sql,
		    array('Ced/Rif','Nombre '),
		    array($objhtml),
		    array('cédula'),
		    450
		    );

	    return $catalogo;
	}

	public static function catalogo_cpimpprct($objhtml)
	{
		$sql="select distinct(a.codpre) as Codigo, b.nompre as Nombre from CPASIINI A,CPDEFTIT B  WHERE A.CODPRE = B.CODPRE  and ( a.codpre like '%V_0%' AND b.nompre like '%V_1%' ) order by a.codpre";

		$catalogo = array(
		    $sql,
		    array('Código Presupuestario','Descripcion de PreCompromiso'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );

	    return $catalogo;
	}
			public static function catalogo_tscheemi_numcue($objhtml)
	{
		$sql="SELECT distinct(a.numcue) as cuenta, b.nomcue from tscheemi a, tsdefban b where a.numcue=b.numcue and ( a.numcue like '%V_0%' and  b.nomcue  like '%V_1%' ) order by a.numcue";

		$catalogo = array(
		    $sql,
		    array('Nro. Cuenta','Nombre Banco'),
		    array($objhtml),
		    array('cuenta'),
		    2000
		    );

	    return $catalogo;
	}

 	public static function catalogo_optipret($objhtml)
	{
		$sql="SELECT distinct(codtip) as codigo, destip as nombre from optipret where ( codtip like '%V_0%' AND destip like '%V_1%' ) order by codtip";
		$catalogo = array(
		    $sql,
		    array('Código','Nombre'),
		    array($objhtml),
		    array('codigo'),
		    450
		    );
	    return $catalogo;
	}
        
        public static function catalogo_benefiarcv($objhtml)
	{
		$sql="SELECT B.CEDRIF, B.NOMBEN FROM OPORDPAG A INNER JOIN OPBENEFI B ON A.CEDRIF=B.CEDRIF LEFT JOIN OPFACTUR C ON C.NUMORD=A.NUMORD WHERE CODISLR<>'' AND ( B.CEDRIF like '%V_0%') and ( B.nomben like '%V_1%') " ;
		$catalogo = array(
		    $sql,
		    array('Ced/Rif','Nombre Beneficiario'),
		    array($objhtml),
		    array('cedrif'),
		    450
		    );

	    return $catalogo;
	}


}

