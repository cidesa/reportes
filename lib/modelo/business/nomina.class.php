<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nomina extends baseClases
{

    /**
     *   REPORTES::nprnomdef.php y nprhisnomdef.php
     *
     * */



    public static function catalogo_codemp($objhtml)
    {
        $sql = "select distinct(cast(REPLACE(a.codemp,'.', '') as int )) as codigo,a.nomemp as nombre from npasicaremp a , nphojint b where a.codemp=b.codemp and b.staemp='A' and ( a.codemp like '%V_0%' AND a.nomemp like '%V_1%' )   order by cast(REPLACE(a.codemp,'.', '') as int )";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codemp_t($objhtml)
    {
        $sql = "select distinct(cast(REPLACE(a.codemp,'.', '') as int )) as codigo,a.nomemp as nombre from npasicaremp a , nphojint b where a.codemp=b.codemp  and ( a.codemp like '%V_0%' AND a.nomemp like '%V_1%' )   order by cast(REPLACE(a.codemp,'.', '') as int )";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_codemp_e($objhtml)
    {
        $sql = "select distinct(cast(REPLACE(a.codemp,'.', '') as int )) as codigo,a.nomemp as nombre from  nphojint a where  a.staemp<>'A' and ( a.codemp like '%V_0%' AND a.nomemp like '%V_1%' )   order by cast(REPLACE(a.codemp,'.', '') as int )";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
	
    public static function catalogo_codemp_rv($objhtml)
    {
        $sql = "select distinct(cast(REPLACE(a.codemp,'.', '') as int )) as codigo,b.nomemp as nombre from nppresocant a,nphojint b where a.codemp=b.codemp  and ( a.codemp like '%V_0%' AND b.nomemp like '%V_1%' )   order by cast(REPLACE(a.codemp,'.', '') as int )";
    
        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );
    
        return $catalogo;
    }
	
	public static function catalogo_codempvac($objhtml)
  {
    $sql="select distinct (a.codemp ), b.nomemp from npvacdisfrute a, nphojint b where a.codemp=b.codemp and  ( a.codemp like '%V_0%' AND b.nomemp like '%V_1%' ) order by a.codemp";

    $catalogo = array(
        $sql,
        array('Codigo Empleado','Nombre Empleado'),
        array($objhtml),
        array('codemp'),
        100
        );

      return $catalogo;
  }
  
   public static function catalogo_periodo($objhtml)
  {
    $sql="select distinct(perfin) as periodo from npvacdisfrute  where  ( perfin like '%V_0%'  ) order by perfin";

    $catalogo = array(
        $sql,
        array('Período'),
        array($objhtml),
        array('perfin'),
        100
        );

      return $catalogo;
  }
	



    public static function catalogo_codcar($objhtml)
    {
        $sql = "SELECT distinct(CODcar) as codigo,nomcar as nombre FROM NPASICAREMP  where ( codcar like '%V_0%' AND nomcar like '%V_1%' ) order by codcar";

        $catalogo = array (
        $sql,
        array ('Codigo Cargo', 'Nombre Cargo'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codcon($objhtml)
    {
        $sql = "SELECT distinct(CODCON) as codigo,NOMCON as nombre FROM NPASICONEMP where ( codcon like '%V_0%' AND nomcon like '%V_1%' ) order by CODCON";

        $catalogo = array (
        $sql,
        array ('Codigo Concepto', 'Nombre Concepto'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codnom($objhtml)
    {
        $sql = "SELECT distinct(CODNOM) as codigo,NOMNOM as nombre FROM NPASICAREMP where ( codnom like '%V_0%' AND nomnom like '%V_1%' ) order by CODNOM";

        $catalogo = array (
        $sql,
        array ('Codigo Nomina', 'Nombre Nomina'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codnom1($objhtml)
    {
        $sql = "SELECT distinct(a.CODNOM) as codigo,a.NOMNOM as nombre FROM npnomina a where ( a.codnom like '%V_0%' AND a.nomnom like '%V_1%' ) order by a.CODNOM ";

        $catalogo = array (
        $sql,
        array ('Codigo Nomina', 'Nombre Nomina'),
        array ($objhtml),
        array ('codigo', 'nomnom'),
        450
        );

        return $catalogo;
    }

    ///////////////////////////////////////////////////////////
    public static function catalogo_codcat($objhtml)
    {
        $sql = "select distinct rtrim(codcat) as codigo,nomcat as nombre from npcatpre order by rtrim(codcat)";

        $catalogo = array (
        $sql,
        array ('Codigo Categoria', 'Nombre Categoria'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codniv($objhtml)
    {
        $sql = "SELECT distinct(CODNIV) as codigo, desniv as Descripcion FROM NPESTORG  where length(rtrim(codniv))=(SELECT MAX (LENGTH(CODNIV)) FROM NPESTORG) and (codniv like '%V_0%' and desniv like '%V_1%' ) ORDER BY CODNIV";

        $catalogo = array (
        $sql,
        array ('Codigo Nivel', 'Descripción'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_tipnom($objhtml)
    {
        $sql = "SELECT distinct(a.CODNOM) as codigo,a.NOMNOM as nombre FROM npnomina a order by a.codnom";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Nombre'),
        array ($objhtml),
        array ('codigo', 'nombre'),
        450
        );

        return $catalogo;
    }



    public static function catalogo_tipnom_especial($objhtml)
    {
        $sql = "SELECT distinct(a.CODNOMESP) as codigo, a.DESNOMESP as nombre FROM npnomesptipos a order by a.codnomesp";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Nombre'),
        array ($objhtml),
        array ('codigo', 'nombre'),
        450
        );

        return $catalogo;
    }


    public static function catalogo_banco($objhtml)
    {
        $sql = "SELECT DISTINCT(CODBAN) as codigo, nomban as nombre FROM NPBANCOS where ( codban like '%V_0%' AND nomban like '%V_1%' ) ORDER BY CODBAN ASC";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Nombre'),
        array ($objhtml),
        array ('codigo', 'nombre'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_cuenta($objhtml)
    {
        $sql = "SELECT DISTINCT(NUMCUE) as codigo, nomcue as nombre FROM TSDEFBAN where ( numcue like '%V_0%' AND nomcue like '%V_1%' ) ORDER BY numcue ASC";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Nombre'),
        array ($objhtml),
        array ('codigo', 'nombre'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_cedemp($objhtml)
    {
        $sql = "select distinct(cedemp) as cedula,nomemp as nombre from nphojint where ( cedemp like '%V_0%' AND nomemp like '%V_1%' ) order by cedemp";

        $catalogo = array (
        $sql,
        array ('Cedula Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('cedula'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_tippre($objhtml)
    {
        $sql = "SELECT distinct(a.codTIPPRE) as codigo,a.destippre as nombre FROM nptippre a  order by a.codtippre ";

        $catalogo = array (
        $sql,
        array ('Codigo Prestamo', 'Nombre Prestamo'),
        array ($objhtml),
        array ('codigo', 'nombre'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_Nphojint_codemp($objhtml)
    {
        $sql = "select distinct(codemp) as codigo,nomemp as nombre from nphojint where ( codemp like '%V_0%' AND nomemp like '%V_1%' ) order by codemp";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_meses($objhtml)
    {
        $sql = "select distinct(to_char(fecnac,'MM')) as mes from nphojint ORDER by mes";

        $catalogo = array (
        $sql,
        array ('Mes'),
        array ($objhtml),
        array ('mes'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_dias($objhtml)
    {
        $sql = "select distinct(to_char(fecnac,'DD')) as dia from nphojint ORDER by dia";

        $catalogo = array (
        $sql,
        array ('Dia'),
        array ($objhtml),
        array ('dia'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codemph($objhtml)
    {
        $sql = "select distinct(codemp) as codigo,nomemp as nombre from nphojint where ( codemp like '%V_0%' AND nomemp like '%V_1%' ) order by codemp";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_npnomina($objhtml)
    {
        $sql = "select codnom as codigo, nomnom as descripcion from npnomina
       where ( codnom like '%V_0%' AND nomnom like '%V_1%' ) order by codnom";


        $catalogo = array (
        $sql,
        array ('Tipo de Nomina', 'Descripcion'),
        array ($objhtml),
        array ('codigo', 'nomnom'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_npnominacodemp($objhtml)
    {
        $sql = "select distinct(a.codemp) as codigo,a.nomemp  as nombre from nphojint a, nphiscon b where ( a.codemp like '%V_0%' AND a.nomemp like '%V_1%' ) and a.codemp=b.codemp  order by a.codemp";

        $catalogo = array (
        $sql,
        array ('Cedula Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_npnominacodcon($objhtml)
    {
        $sql = "select codcon as codigo, nomcon  as nombre from npdefcpt where ( codcon like '%V_0%' AND nomcon like '%V_1%' ) order by codcon";

        $catalogo = array (
        $sql,
        array ('Concepto', 'Descripcion'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_codempliq($objhtml)
    {
        $sql = "select distinct (a.codemp) as codigo,b.nomemp as nombre from npliquidacion_det a,nphojint b where a.codemp=b.codemp and ( a.codemp like '%V_0%' AND b.nomemp like '%V_1%' ) order by a.codemp";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre Empleado'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_motliq($objhtml)
    {
        $sql = "select desmotliq as nombre from npmotliq where ( desmotliq like '%V_0%' ) order by desmotliq";

        $catalogo = array (
        $sql,
        array ('Nombre Motivo'),
        array ($objhtml),
        array ('nombre'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_codret($objhtml)
    {
        $sql = "select desret as descripción from nptipret where ( desret like '%V_0%' ) order by desret";

        $catalogo = array (
        $sql,
        array ('Descripción'),
        array ($objhtml),
        array ('descripción'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_codnivedu($objhtml)
    {
        $sql = "select codniv as codigo, desniv  as descripcion from NPNIVEDU where ( codniv like '%V_0%' AND desniv like '%V_1%' ) order by codniv";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Descripción'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codprofes($objhtml)
    {
        $sql = "select codprofes as codigo , desprofes  as descripcion from NPPROFESION where ( codprofes like '%V_0%' AND desprofes like '%V_1%') order by codprofes";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Descripción'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }
    public static function catalogo_codtipapo($objhtml)
    {
        $sql = "SELECT distinct CODTIPAPO as codigo ,DESTIPAPO as descripcion FROM NPTIPAPORTES  where ( CODTIPAPO like '%V_0%' AND DESTIPAPO like '%V_1%') order by CODTIPAPO";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Descripción'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codtiket($objhtml)
    {
        $sql = "SELECT distinct codcon as codigo, nomcon as descripcion FROM NPASICONEMP  where nomcon like '%TICK%' and ( cq<odcon like '%V_0%' AND nomcon like '%V_1%')  order by codcon";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Descripción'),
        array ($objhtml),
        array ('codigo'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codempdes($objhtml)
    {
        $sql = "SELECT distinct(CODEMP) as codigo, nomemp as nombre FROM NPASICAREMP where (CODEMP like '%V_0%' AND nomemp like '%V_1%')order by codemp";

        $catalogo = array (
        $sql,
        array ('Codigo Empleado', 'Nombre del empleado'),
        array ($objhtml),
        array ('codigo', 'Nombre del empleado'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codmuni($objhtml)
    {
        $sql = "SELECT  distinct(a.codedo) as codigo, a.nomedo as municipio, b.nompai as estado FROM npestado a, nppais b where a.codpai=b.codpai and (a.codedo like '%V_0%' AND b.nompai like '%V_1%')order by a.codedo";

        $catalogo = array (
        $sql,
        array ('Codigo', 'Nombre'),
        array ($objhtml),
        array ('codigo', 'Nombre'),
        450
        );

        return $catalogo;
    }

    public static function catalogo_codpais($objhtml)
    {
        $sql = "SELECT  distinct(codpai) as codigo, nompai as nombre FROM nppais (codpai like '%V_0%' AND nompai like '%V_1%')order by codpai";

        $catalogo = array (
        $sql,
        array ('Codigo Estado', 'Nombre Estado'),
        array ($objhtml),
        array ('codigo Estado', 'Nombre Estado'),
        450
        );

        return $catalogo;
    }
	
	
    
}
