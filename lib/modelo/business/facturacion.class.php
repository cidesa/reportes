<?php
require_once("../../lib/modelo/baseClases.class.php");

class Facturacion extends baseClases
{

/**
 *   REPORTES::nprnomdef.php y nprhisnomdef.php
 *
 * */

 	public static function catalogo_articulo($objhtml)
	{
		$sql="select codart as articulo, desart as descripcion, exitot as existencia from CAREGART where (codart like '%V_0%' AND desart like '%V_1%' AND exitot like '%V_2%') order by codart";

		$catalogo = array(
		    $sql,
		    array('Articulo','Descripción','Existencia'),
		    array($objhtml),
		    array('articulo','descripcion','existencia'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_pago($objhtml)
	{
		$sql="select (id) as codigo,(desconpag) as descripcion from faconpag
        where (id like '%V_0%' AND desconpag like '%V_1%' ) order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_existencia($objhtml)
	{
		$sql="select exitot as existencia from CAREGART where (exitot like '%V_0%') order by exitot";

		$catalogo = array(
		    $sql,
		   array('Existencia Total'),
		    array($objhtml),
		    array('existencia'),
		    100
		    );

	    return $catalogo;
	}


	public static function catalogo_clientes($objhtml)
	{
		$sql="select (CODPRO) as codigo from FACLIENTE
        where (CODPRO like '%V_0%') order by CODPRO";

		$catalogo = array(
		    $sql,
		    array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

   	public static function catalogo_rifclientes($objhtml)
	{
		$sql="select rifpro as rif from FACLIENTE
        where (rifpro like '%V_0%') order by rifpro";
		$catalogo = array(
		    $sql,
		    array('Rif'),
		    array($objhtml),
		    array('rif'),
		    100
		    );

	    return $catalogo;
	}

   	public static function catalogo_nomclientes($objhtml)
	{
		$sql="select (NOMPRO) as nombre from FACLIENTE
        where (NOMPRO like '%V_0%') order by NOMPRO";

		$catalogo = array(
		    $sql,
		    array('Nombre'),
		    array($objhtml),
		    array('nombre'),
		    100
		    );

	    return $catalogo;
	}

   	public static function catalogo_condipago($objhtml)
	{
		$sql="select (id) as codigo, desconpag as condicion from FACONPAG
        where (id like '%V_0%') order by id";

		$catalogo = array(
		    $sql,
		    array('Codigo','Condicion de Pago'),
		    array($objhtml),
		    array('codigo','condicion'),
		    100
		    );

	    return $catalogo;
	}


	public static function catalogo_lotearticulo($objhtml)
	{
		$sql="select a.codart as codigo, a.desart as descripcion from CAREGART a, fadeflot b where a.codart=b.codart and (a.codart like '%V_0%' AND a.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		   array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_lote($objhtml)
	{
		$sql="select numlot as numero, deslot as descripcion from  fadeflot  where (numlot like '%V_0%' AND deslot like '%V_1%') order by numlot";

		$catalogo = array(
		    $sql,
		   array('Numero de Lote','Descripción'),
		    array($objhtml),
		    array('numero','descripcion'),
		    100
		    );

	    return $catalogo;
	}


	public static function catalogo_prearticulo($objhtml)
	{
	    $sql="select a.codart as codigo, a.desart as descripcion from CAREGART a, FAARTPVP b where a.codart=b.codart and  (a.codart like '%V_0%' AND a.desart like '%V_1%') order by a.codart";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_precioart($objhtml)
	{
		$sql="select (ID) as codigo, despvp as nombre, pvpart as precio from FAARTPVP  where (ID like '%V_0%') and (despvp like '%V_1%') and (pvpart like '%V_2%') order by ID";
		    $catalogo = array(
		    $sql,
		    array('Codigo de Precio','Descripción','Precio'),
		    array($objhtml),
		    array('codigo','nombre','precio'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_descuento($objhtml)
	{
	    $sql="select coddesc as codigo, desdesc as descripcion from FADESCTO where (coddesc like '%V_0%' AND desdesc like '%V_1%') order by coddesc";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

	 public static function catalogo_artalt($objhtml)
	{
		//$sql="select codart as codigo from FAPROALT where (codart like '%V_0%') order by codart";
        $sql="SELECT A.CODART as codigo, B.DESART as nombre
		FROM FAPROALT A,CAREGART B
		WHERE
		A.CODART=B.CODART and (a.codart like '%V_0%') and (b.desart like '%V_1%')
		ORDER BY B.DESART";
		$catalogo = array(
		    $sql,
		   array('CÓDIGO','NOMBRE'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_descart($objhtml)
	{
		$sql="select desart as desc from CAREGART where (desart like '%V_0%') order by desart";

		$catalogo = array(
		    $sql,
		   array('DESCRIPCIÓN'),
		    array($objhtml),
		    array('desc'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_recargos($objhtml)
	{
		$sql="select CODRGO as codigo, nomrgo as nombre from carecarg where (CODRGO like '%V_0%') and (nomrgo like '%V_1%') order by CODRGO";

		$catalogo = array(
		    $sql,
		   array('CÓDIGO','RECARGO'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_recaudos($objhtml)
	{
		$sql="select codrec as codigo from CARECAUD where (codrec like '%V_0%') order by codrec";

		$catalogo = array(
		    $sql,
		   array('RECAUDO'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_tipcte($objhtml)
	{
		$sql="select ID as codigo, nomtipcte as nombre from FATIPCTE where (ID like '%V_0%') and (nomtipcte like '%V_1%') order by ID";

		$catalogo = array(
		    $sql,
		   array('CODIGO','TIPO DE CLIENTE'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_tipdes($objhtml)
	{
		$sql="select ID as codigo, nomdes as nombre from FAFORDES where (ID like '%V_0%') and (nomdes like '%V_1%') order by ID";

		$catalogo = array(
		    $sql,
		   array('CODIGO','TIPO DE DESPACHO'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_tipdev($objhtml)
	{
		$sql="select ID as codigo, nomtidev as nombre from FATIPDEV where (ID like '%V_0%') and (nomtidev like '%V_1%') order by ID";

		$catalogo = array(
		    $sql,
		   array('CÓDIGO','TIPO DE DEVOLUCIÓN'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_factura($objhtml)
	{
		$sql="select REFFAC as factura, desfac as descripcion from FAFACTUR where (REFFAC like '%V_0%' AND desfac like '%V_1%') order by REFFAC";

		$catalogo = array(
		    $sql,
		    array('Factura','Descripción'),
		    array($objhtml),
		    array('factura','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_facclientes($objhtml)
	{
		$sql="select distinct(a.codcli) as codigo, a.nomcli as nombre from cobclient a, FAFACTUR b where B.CODCLI=A.codcli AND
        (a.codcli like '%V_0%' AND a.nomcli like '%V_1%') order by a.CODCLI";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_consigarticulo($objhtml)
	{
	    $sql="select a.codart as codigo, a.desart as descripcion from CAREGART a, FAARTPRO b  where a.codart=b.codart and (a.codart like '%V_0%' AND a.desart like '%V_1%') order by a.codart";
		$catalogo = array(
		    $sql,
		    array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}

    public static function catalogo_personas($objhtml)
	{
		$sql="select (codpro) as codigo, nompro as nombre from FACLIENTE where (CODPRO like '%V_0%' AND nompro like '%V_1%') order by CODPRO";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_presuparticulo($objhtml)
	{
		$sql="select a.codart as codigo, b.desart as descripcion from FADETPRE A, CAREGART B WHERE A.CODART = B.CODART and (a.codart like '%V_0%' AND b.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		   array('Codigo','Descripción'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );
	    return $catalogo;
	}


	 public static function catalogo_presupuesto($objhtml)
	{
		$sql="select REFPRE as codigo, despre as nombre from FAPRESUP where (REFPRE like '%V_0%'  AND despre like '%V_1%') order by REFPRE";
		    $catalogo = array(
		    $sql,
		   array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;

	}

	public static function catalogo_farticulo($objhtml)
	{
		$sql="select distinct( a.codart) as articulo, b.desart as descripcion from FAARTFAC A,CAREGART B where A.CODART = B.CODART and (a.codart like '%V_0%' AND b.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		    array('Articulo','Descripción'),
		    array($objhtml),
		    array('articulo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_notent($objhtml)
	{
		$sql="select nronot as codigo from FANOTENT where (nronot like '%V_0%') order by nronot";

		$catalogo = array(
		    $sql,
		   array('NOTA DE ENTREGA'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

  public static function catalogo_codcli($objhtml)
	{
		$sql="select codcli as codigo from FANOTENT where (codcli like '%V_0%') order by codcli";

		$catalogo = array(
		    $sql,
		   array('CI/RIF CLIENTE'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_mercancia($objhtml)
	{
		$sql="select (CONMER) as condicion, descon as descripcion from CACONMER
        where (CONMER like '%V_0%' and descon like '%V_1%') order by CONMER";

		$catalogo = array(
		    $sql,
		    array('Codigo','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_proveedor($objhtml)
	{
		$sql="select A.CODPRO as codigo, a.nompro as nombre from CAPROVEE a, CACONMER b  where A.CODPRO = B.CODPRO and (A.CODPRO like '%V_0%'and a.nompro like '%V_1%') order by A.CODPRO";

		$catalogo = array(
		    $sql,
		   array('CI/RIF CLIENTE'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

    public static function catalogo_artmercancia($objhtml)
	{
		$sql="select a.codart as articulo, a.desart as descripcion from CAREGART A,CAMERCON B where A.CODART = B.CODART and (a.codart like '%V_0%' AND a.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		    array('Articulo','Descripción'),
		    array($objhtml),
		    array('articulo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_almacen($objhtml)
	{
		$sql="select A.CODALM as codigo, B.NOMALM as nombre FROM CACONMER A, CADEFALM B WHERE
				A.CODALM = B.CODALM and (A.CODALM like '%V_0%' and B.NOMALM like '%V_1%') order by A.CODALM";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}
   public static function catalogo_codcli_pedido($objhtml)
	{
		$sql="select codcli as codigo from FAPEDIDO where (codcli like '%V_0%') order by codcli";

		$catalogo = array(
		    $sql,
		   array('CI/RIF CLIENTE'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

 public static function catalogo_pedido($objhtml)
	{
		$sql="select nroped as codigo from FAPEDIDO where (nroped like '%V_0%') order by nroped";

		$catalogo = array(
		    $sql,
		   array('Pedido'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}

	 public static function catalogo_notasclientes($objhtml)
	{
		$sql="select a.codcli as codigo, b.nompro as nombre from FANOTENT a, facliente b where a.codcli=b.codpro and (a.codcli like '%V_0%' and b.nompro like '%V_1%') order by a.codcli";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_notarticulo($objhtml)
	{
		$sql="select a.codart as articulo, b.desart as descripcion from FAARTNOT A,CAREGART B where A.CODART = B.CODART and (a.codart like '%V_0%' AND b.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		    array('Articulo','Descripción'),
		    array($objhtml),
		    array('articulo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_pedidoarticulo($objhtml)
	{
		$sql="select a.codart as articulo, b.desart as descripcion from FAARTPED A,CAREGART B where A.CODART = B.CODART and (a.codart like '%V_0%' AND b.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		    array('Articulo','Descripción'),
		    array($objhtml),
		    array('articulo','descripcion'),
		    100
		    );

	    return $catalogo;
	}



	 public static function catalogo_pedidosclientes($objhtml)
	{
		$sql="select a.codcli as codigo, b.nompro as nombre from FAPEDIDO a, facliente b where a.codcli=b.codpro and (a.codcli like '%V_0%' and b.nompro like '%V_1%') order by a.codcli";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_pedidos($objhtml)
	{
		$sql="select nroped as codigo, desped as descripcion from FAPEDIDO where (nroped like '%V_0%' and desped like '%V_1%') order by nroped";

		$catalogo = array(
		    $sql,
		   array('Numero Pedido','Descripcion'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_despachoclientes($objhtml)
	{
		$sql="select a.codcli as codigo, b.nompro as nombre from CADPHART a, facliente b where a.codcli=b.codpro and (a.codcli like '%V_0%' and b.nompro like '%V_1%') order by a.codcli";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_despachoarticulo($objhtml)
	{
		$sql="select a.codart as articulo, b.desart as descripcion from CAARTDPH A,CAREGART B where A.CODART = B.CODART and (a.codart like '%V_0%' and b.desart like '%V_1%') order by a.codart";

		$catalogo = array(
		    $sql,
		    array('Articulo','Descripción'),
		    array($objhtml),
		    array('articulo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_depachoalmacen($objhtml)
	{
		$sql="select A.CODALM as codigo, B.NOMALM as nombre FROM CADPHART A, CADEFALM B WHERE
				A.CODALM = B.CODALM and (A.CODALM like '%V_0%' and B.NOMALM like '%V_1%') order by A.CODALM";

		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}
    public static function catalogo_condpag($objhtml)
	{
		$sql="select codconpag as codigo, desconpag as condicion from CACONPAG  where  (codconpag like '%V_0%' AND desconpag like '%V_1%') order by codconpag";

		$catalogo = array(
		    $sql,
		    array('Código','Condición de Pago'),
		    array($objhtml),
		    array('codigo','condicion'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_presupclientes($objhtml)
	{
		$sql="select a.codcli as codigo, b.nompro as nombre from FAPRESUP a, facliente b where a.codcli=b.codpro and (a.codcli like '%V_0%' and b.nompro like '%V_1%') order by a.codcli";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_presup($objhtml)
	{
		$sql="SELECT DISTINCT (REFPRE) as codigo FROM FAPRESUP where (REFPRE like '%V_0%') ORDER BY REFPRE";

		$catalogo = array(
		    $sql,
		   array('Codigo'),
		    array($objhtml),
		    array('codigo'),
		    100
		    );

	    return $catalogo;
	}
    public static function catalogo_despacho($objhtml)
    {
        $sql="SELECT DISTINCT (dphart) as codigo FROM CADPHART where (dphart like '%V_0%') ORDER BY dphart";




        $catalogo = array(
            $sql,
           array('Codigo'),
            array($objhtml),
            array('codigo'),
            100
            );

        return $catalogo;
    }

    public static function catalogo_despclientes($objhtml)
    {
        $sql="select a.codcli as codigo, b.nompro as nombre from CADPHART a, facliente b where a.codcli=b.codpro and (a.codcli like '%V_0%' and b.nompro like '%V_1%') order by a.codcli";

        $catalogo = array(
            $sql,
           array('Codigo','Nombre'),
            array($objhtml),
            array('codigo','nombre'),
            100
            );

        return $catalogo;
    }


    public static function catalogo_paises($objhtml)
	{
		$sql="select id as codigo, nompai as nombre from Fapais where (id like '%V_0%' AND nompai like '%V_1%') order by id";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	 public static function catalogo_estado($objhtml)
	{
		$sql="select a.id as codigo, a.nomedo as estado,b.nompai as pais from Faestado a, Fapais b where b.id=fapais_id and (a.id like '%V_0%' AND a.nomedo like '%V_1%' and b.nompai like '%V_2%') order by a.id";
		$catalogo = array(
		    $sql,
		    array('Codigo','Estado','Pais'),
		    array($objhtml),
		    array('codigo','estado','pais'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_paisestado($objhtml)
	{
		$sql="select id as codigo, nompai as nombre from Fapais where (id like '%V_0%' AND nompai like '%V_1%') order by nompai";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

    public static function catalogo_ciudades($objhtml)
	{
		$sql="select a.id as codigo, a.nomciu as ciudad,b.nomedo as estado from Faciudad a, faestado b where b.id=a.faestado_id and (a.id like '%V_0%' AND a.nomciu like '%V_1%' and b.nomedo like '%V_2%') order by a.id";
		$catalogo = array(
		    $sql,
		    array('Codigo','Ciudad','Estado'),
		    array($objhtml),
		    array('codigo','ciudad','estado'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_estadociudad($objhtml)
	{
		$sql="select DISTINCT a.id as codigo, (a.nomedo) as nombre, b.nompai as pais from Faestado a, FAPAIS b where b.id=a.fapais_id and (a.id like '%V_0%' AND a.nomedo like '%V_1%' and b.nompai like '%V_2%') order by a.id";
		$catalogo = array(
		    $sql,
		    array('Codigo','Estado','Pais'),
		    array($objhtml),
		    array('codigo','nombre','pais'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_marca($objhtml)
	{
		$sql="select id as codigo, nommar as nombre from famarca where (id like '%V_0%' and nommar like '%V_1%') order by id";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

    	public static function catalogo_recargoarticulo($objhtml)
	{
		$sql="select codrgo as codigo, nomrgo as nombre from farecarg where (codrgo like '%V_0%' and nomrgo like '%V_1%') order by codrgo";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}
	public static function catalogo_bancos($objhtml)
	{
		$sql="select id as codigo, nomban as nombre from fabancos where (id like '%V_0%' and nomban like '%V_1%') order by id";

		$catalogo = array(
		    $sql,
		   array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );

	    return $catalogo;
	}

	public static function catalogo_forsol($objhtml)
	{
		$sql="select id as codigo, nomsol as nombre from Faforsol where (id like '%V_0%' AND nomsol like '%V_1%') order by nomsol";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_tippag($objhtml)
	{
		$sql="select id as codigo, destippag as nombre from Fatippag where (id like '%V_0%' AND destippag like '%V_1%') order by destippag";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	public static function catalogo_tipmov($objhtml)
	{
		$sql="select id as codigo, desmov as nombre from Fatipmov where (id like '%V_0%' AND desmov like '%V_1%') order by desmov";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

		public static function catalogo_tipoalmacen($objhtml)
	{
		$sql="select id as codigo, nomtip as nombre from catipalm where (id like '%V_0%' AND nomtip like '%V_1%') order by id";
		$catalogo = array(
		    $sql,
		    array('Codigo','Nombre'),
		    array($objhtml),
		    array('codigo','nombre'),
		    100
		    );
	    return $catalogo;
	}

	  public static function catalogo_tiprec($objhtml)
	{
		$sql="select codtiprec as codigo,destiprec as descripcion from CATIPREC where (codtiprec like '%V_0%' and destiprec like '%V_1%') order by codtiprec";

		$catalogo = array(
		    $sql,
		   array('GRUPO','DESCRIPCION'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

		  public static function catalogo_cajas($objhtml)
	{
		$sql="select codcaj as codigo,descaj as descripcion from FADEFCAJ where (codcaj like '%V_0%' and descaj like '%V_1%') order by codcaj";

		$catalogo = array(
		    $sql,
		   array('CODIGO','DESCRIPCION'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}

	 public static function catalogo_precios_lotes($objhtml)
	{
		$sql="select DISTINCT id as codigo,despvp as descripcion from faartpvp where (id like '%V_0%' and despvp like '%V_1%') order by id";

		$catalogo = array(
		    $sql,
		   array('CODIGO','DESCRIPCION'),
		    array($objhtml),
		    array('codigo','descripcion'),
		    100
		    );

	    return $catalogo;
	}




   }
