<?php
require_once("../../lib/modelo/baseClases.class.php");

class Hacienda extends baseClases
{
public static function catalogo_solvencia($objhtml)
	{
		$sql="select distinct codtip as codigo, destip as descripcion from fctipsol where (codtip like '%V_0%' and destip like '%V_1%') order by codtip";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

public static function catalogo_rutas($objhtml)
	{
		$sql="select distinct codrut as codigo, desrut as descripcion from fcrutas where (codrut like '%V_0%' and desrut like '%V_1%') order by codrut";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

		public static function catalogo_tippag($objhtml)
	{
		$sql="select id as codigo, despag as nombre from fctippag where (id like '%V_0%' AND despag like '%V_1%') order by despag";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}


		public static function catalogo_recargo($objhtml)
	{
		$sql="select codrec as codigo, nomrec as nombre from fcdefrecint where (codrec like '%V_0%' AND nomrec like '%V_1%') order by codrec";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_tasas($objhtml)
	{
		$sql="select DISTINCT tasano as codigo from fctasban where (tasano like '%V_0%') order by tasano ";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_descuento($objhtml)
	{
		$sql="select coddes as codigo, nomdes as nombre from fcdefdesc where (coddes like '%V_0%' AND nomdes like '%V_1%') order by coddes";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_multas($objhtml)
	{
		$sql="select codmul as codigo, nommul as nombre from fcmultas where (codmul like '%V_0%' AND nommul like '%V_1%') order by codmul";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_tiplic($objhtml)
	{
		$sql="select codtiplic as codigo, destiplic as descripcion from fctiplic where (codtiplic like '%V_0%' AND destiplic like '%V_1%') order by codtiplic";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

  	public static function catalogo_actividad($objhtml)
	{
		$sql="select codact as codigo, desact as descripcion from fcactcom where (codact like '%V_0%' AND desact like '%V_1%') order by codact";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

		public static function catalogo_actan($objhtml)
	{
		$sql="select DISTINCT ANOACT as codigo from fcactcom where (codact like '%V_0%') order by ANOACT";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

  public static function catalogo_inmueble($objhtml)
	{
		$sql="select distinct codusoinm as codigo, nomusoinm as descripcion from FCUSOINM where (codusoinm like '%V_0%' AND nomusoinm like '%V_1%') order by codusoinm";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_cainmueble($objhtml)
	{
		$sql="select distinct codcarinm as codigo, nomcarinm as descripcion from FCCARINM where (codcarinm like '%V_0%' AND nomcarinm like '%V_1%') order by codcarinm";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_tipnmueble($objhtml)
	{
		$sql="select distinct CODESTINM as codigo, DESESTINM as descripcion from FCESTINM where (CODESTINM like '%V_0%' AND DESESTINM like '%V_1%') order by CODESTINM";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


	public static function catalogo_situaciones($objhtml)
	{
		$sql="select distinct codsitinm as codigo, nomsitinm as descripcion from fcsitjurinm where (codsitinm like '%V_0%' AND nomsitinm like '%V_1%') order by codsitinm";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}
	public static function catalogo_catastro($objhtml)
	{
		$sql="select distinct codpar as codigo from fcdefnca where (codpar like '%V_0%') order by codpar";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

   	public static function catalogo_catfiscales($objhtml)
	{
		$sql="select distinct codcatfis as codigo, nomcatfis as descripcion from fccatfis where (codcatfis like '%V_0%' AND nomcatfis like '%V_1%') order by codcatfis";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

      	public static function catalogo_inmuebleurbano($objhtml)
	{
		$sql="select distinct codcom as codigo, descom as descripcion from fccominm where (codcom like '%V_0%' AND descom like '%V_1%') order by codcom";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

		public static function catalogo_vigencia($objhtml)
	{
		$sql="select distinct anovig as codigo from fccominm where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	      	public static function catalogo_impuesto($objhtml)
	{
		$sql="select distinct id as codigo, despgi as descripcion from fcdefpgi where (id like '%V_0%' AND despgi like '%V_1%') order by id";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

			public static function catalogo_vigencia1($objhtml)
	{
		$sql="select distinct anovig as codigo from fcusoveh where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}
	      	public static function catalogo_vehiculo($objhtml)
	{
		$sql="select distinct coduso as codigo, desuso as descripcion from fcusoveh where (coduso like '%V_0%' AND desuso like '%V_1%') order by coduso";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

			public static function catalogo_vigencia2($objhtml)
	{
		$sql="select distinct anovig as codigo from fctipapu where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

		      	public static function catalogo_apuesta($objhtml)
	{
		$sql="select distinct tipapu as tipo, destip as descripcion from fctipapu where (tipapu like '%V_0%' AND destip like '%V_1%') order by tipapu";
		$catalogo = array(
		    $sql,
		    array('Tipo','Descripcion'),
		    array($objhtml),
		    array('tipo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


				public static function catalogo_vigencia3($objhtml)
	{
		$sql="select distinct anovig as codigo from fctipesp where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

		      	public static function catalogo_espectaculos($objhtml)
	{
		$sql="select distinct tipesp as tipo, destip as descripcion from fctipesp where (tipesp like '%V_0%' AND destip like '%V_1%') order by tipesp";
		$catalogo = array(
		    $sql,
		    array('Tipo','Descripcion'),
		    array($objhtml),
		    array('tipo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


				public static function catalogo_vigencia4($objhtml)
	{
		$sql="select distinct anovig as codigo from fctippro where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

		      	public static function catalogo_propaganda($objhtml)
	{
		$sql="select distinct tippro as tipo, destip as descripcion from fctippro where (tippro like '%V_0%' AND destip like '%V_1%') order by tippro";
		$catalogo = array(
		    $sql,
		    array('Tipo','Descripcion'),
		    array($objhtml),
		    array('tipo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

		      	public static function catalogo_depreciacion($objhtml)
	{
		$sql="select distinct anovig as codigo from fcdprinm where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

				public static function catalogo_vigencia5($objhtml)
	{
		$sql="select distinct anovig as codigo from fcvalinm where (anovig like '%V_0%') order by anovig";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

		      	public static function catalogo_zonas($objhtml)
	{
		$sql="select distinct codzon as codigo, deszon as descripcion from fcvalinm where (codzon like '%V_0%' AND deszon like '%V_1%') order by codzon";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

    		  	public static function catalogo_contribuyente($objhtml)
	{
		$sql="select distinct rifcon as codigo, nomcon as nombre from fcconrep where (rifcon like '%V_0%' AND nomcon like '%V_1%') order by rifcon";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

	    		public static function catalogo_contribuyente_1($objhtml)
	{
		$sql="select distinct rifcon as codigo, nomcon as nombre from fcpagos where (rifcon like '%V_0%' AND nomcon like '%V_1%') order by rifcon";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


   	    public static function catalogo_solvencia_1($objhtml)
	{
		$sql="select distinct codsol as codigo from FCSOLVENCIA where (codsol like '%V_0%') order by codsol";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


	   public static function catalogo_tiposolvencia($objhtml)
	{
		$sql="select distinct codtip as codigo, destip as nombre from fctipsol where (codtip like '%V_0%' AND destip like '%V_1%') order by codtip";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

   public static function catalogo_solicitud($objhtml)
	{
		$sql="select distinct nroinm as codigo from fcreginm where (nroinm like '%V_0%') order by nroinm";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

     public static function catalogo_lisinmuebles($objhtml)
	{
		$sql="select distinct codcatinm as codigo from fcreginm where (codcatinm like '%V_0%') order by codcatinm";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_numlic($objhtml)
	{
		$sql="select distinct numlic as codigo from FCSOLLIC where (numlic like '%V_0%') order by numlic";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_numsol($objhtml)
	{
		$sql="select distinct numsol as codigo from FCSOLLIC where (numsol like '%V_0%') order by numsol";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_numsol1($objhtml)
	{
		$sql="SELECT DISTINCT(A.NUMLIC) AS codigo FROM FCSOLLIC A, FCDECLAR B WHERE A.NUMLIC=B.NUMREF and (a.numlic like '%V_0%') ORDER BY A.NUMLIC";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_declara($objhtml)
	{
		$sql="SELECT DISTINCT(ANODEC) AS codigo FROM FCDECLAR WHERE ANODEC<>'' AND UPPER(ANODEC) LIKE UPPER('%') ORDER BY ANODEC";
		$catalogo = array(
		    $sql,
		    array('Año'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}


	public static function catalogo_cajero($objhtml)
	{
		$sql="Select distinct(funpag) as funpag from fcpagos  where funpag like '%V_0%' order by funpag";
		$catalogo = array(
		    $sql,
		    array('Cajero'),
		    array($objhtml),
		    array('funpag'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_lislicencias($objhtml)
	{
		$sql="SELECT DISTINCT(numlic) AS codigo FROM FCSOLLIC  WHERE (numlic like '%V_0%') ORDER BY numlic";
		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

	      	public static function catalogo_riflic($objhtml)
	{
		$sql="select distinct a.rifcon as codigo, b.nomcon as nombre from fcsollic a,fcconrep b where a.rifcon=b.rifcon and (a.rifcon like '%V_0%' AND b.nomcon like '%V_1%') order by a.rifcon";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}
  	public static function catalogo_actieconimica($objhtml)
	{
		$sql="select a.codact as codigo, b.desact as descripcion from fcactpic a,fcactcom b where a.codact=b.codact and (a.codact like '%V_0%' AND b.desact like '%V_1%') order by a.codact";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


   	public static function catalogo_tipolicencia($objhtml)
	{
		$sql="select codtiplic as codigo, destiplic as descripcion from fctiplic where (codtiplic like '%V_0%' AND destiplic like '%V_1%') order by codtiplic";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}
      	public static function catalogo_funcionario($objhtml)
	{
		$sql="select distinct funsus as nombre from FCSUSCAN where  (funsus like '%V_0%') order by funsus";
		$catalogo = array(
		    $sql,
		    array('Funcionario'),
		    array($objhtml),
		    array('nombre'),
		    100
		    );
	    return $catalogo;
	}

	 	public static function catalogo_ramo($objhtml)
	{


		$sql="SELECT distinct(CODFUE) as codigo,nomfue as nombre FROM FCFUEPRE where upper(nomfue) like upper('%') order by codfue";
		$catalogo = array(
		    $sql,
		    array('Ramo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}

public static function catalogo_rubro($objhtml)
	{
		$sql="select distinct codfue as codigo, nomfue as nombre from fcrutas where (codfue like '%V_0%' and nomfue like '%V_1%') order by codfue";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_jurada($objhtml)
	{
		$sql="SELECT DISTINCT(NUMDEC) AS numero FROM FCDECLAR WHERE (NUMDEC like '%V_0%') order by NUMDEC";
		$catalogo = array(
		    $sql,
		    array('Numero'),
		    array($objhtml),
		    array('numero'),
		    100
		    );
	    return $catalogo;
	}

		public static function catalogo_fuenteing($objhtml)
	{
		$sql= "SELECT DISTINCT A.FUEING as codigo,B.NOMFUE as fuente FROM FCDECLAR A,FCFUEPRE B,FCREGINM C WHERE  A.OTRO=C.CODCATINM AND	A.FUEING=B.CODFUE and (A.FUEING like '%V_0%' and B.NOMFUE like '%V_1%') ORDER BY A.FUEING desc";

		$catalogo = array(
		    $sql,
		    array('Codigo','Fuente'),
		    array($objhtml),
		    array('codigo','fuente'),
		    100
		    );
	    return $catalogo;
	}

		public static function catalogo_anualpic($objhtml)
	{
		$sql="SELECT DISTINCT(ANODEC) AS codigo FROM FCACTPIC WHERE ANODEC<>'' AND UPPER(ANODEC) LIKE UPPER('%') ORDER BY ANODEC";
		$catalogo = array(
		    $sql,
		    array('Año'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );
	    return $catalogo;
	}


	 	public static function catalogo_contribuyente_pic($objhtml)
	{
		$sql="select distinct rifcon as codigo, nomcon as nombre from fcconrep where (rifcon like '%V_0%' AND nomcon like '%V_1%') order by rifcon";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

	      	public static function catalogo_lic_pic($objhtml)
	{
		$sql="select distinct a.numlic as numero from fcsollic a,FCACTPIC b where a.numlic=b.numdoc and (a.numlic like '%V_0%') order by a.numlic";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}
   	public static function catalogo_numpag($objhtml)
	{
		$sql="Select distinct(numpag) as numpag from fcpagos  where numpag >0 and (numpag like '%V_0%') order by numpag";
		$catalogo = array(
		    $sql,
		    array('Número'),
		    array($objhtml),
		    array('numpag'),
		    100
		    );
	    return $catalogo;
	}


}
