<?php

require_once("../../lib/modelo/baseClases.class.php");

class Farfacpreimp extends baseClases {

  function sqlp($CODDES, $CODHAS) {
    //ENCABEZADO
    $sql = "select distinct (a.reffac) as reffac, to_char(a.fecfac,'dd/mm/yyyy') as fecha, a.codcli as codcli,
           b.nompro as cliente,b.dirpro as direccion, b.telpro as telefono, b.rifpro as rif, b.nitpro as nit,
           h.desconpag as forma,a.numcontrol as numcontrol,
	   a.tipref as tipref,
	       a.monfac,
           a.status,
           a.desfac as observacion,i.nomedo as estado,j.descenaco as centroacopio
           from fafactur a
           left outer join faconpag h on (a.codconpag=h.id)
           
           left outer join cadefcenaco j on a.codcenaco=j.codcenaco,
           facliente b left outer join ocestado i on b.codedo=i.codedo,
           faartfac f
           where
           a.codcli=b.codpro and
           f.reffac=a.reffac and
           a.reffac >= '" . $CODDES . "' and
           a.reffac <= '" . $CODHAS . "'
           order by reffac ";

  //H::PrintR($sql);exit; c.destippag as pago d.monpag as monto, d.numero as numero, left outer join faforpag d on (a.reffac=d.reffac)
           //left outer join fatippag c on (d.tippag=c.id)
    return $this->select($sql);
  }

  function sqlp1($CODIGO) {
    //DETALLE DE ARTICULOS

	 $sql = "select e.codart as codart, f.desart as articulo, e.unimed as present,
           case when (f.monrgo=0 or f.monrgo isnull) then '(E)' else '   ' end as exento,
           sum(f.cantot) as cantidad,
           f.precio as precio,
           sum(f.monrgo) as recargo,
           sum(f.mondes) as modes,
           sum(f.totart) as totart,
           f.orddespacho,f.nronot,f.guia,f.contenedores,f.billleading
           from
           caregart e,
           faartfac f
           where
           e.codart=f.codart and
           f.reffac = '" . $CODIGO . "'
           group by e.codart,f.desart,e.unimed,f.precio,f.orddespacho,f.nronot,f.guia,f.contenedores,f.billleading,f.monrgo
           order by codart";

   //H::PrintR($sql);exit;
    return $this->select($sql);
  }

  function sqlp2($CODIGO) {  /// Este SQL se usará si se decide que pueda sumarse los montos parciales de la Factura
    $sql = "select SUM(monpag) as monto
           from faforpag
           where
           reffac = '" . $CODIGO . "'
           group by reffac
           order by reffac ";

   //H::PrintR($sql);exit;
    return $this->select($sql);
  }

  function sqlp3($CODIGO) {
    //RECARGO
    $sql = "select   distinct(b.monrgo) as recargo from
           fargoart a, farecarg b
           where
           a.codrgo=b.codrgo and
           a.refdoc='" . $CODIGO . "'";

    //H::PrintR($sql);exit;
    return $this->select($sql);
  }
  
  function sqlrefencias($CODIGO){
      $sql="select distinct(codref) as codref from faartfac where reffac='".$CODIGO."'";
      return $this->select($sql);
  }

  function sqlp5($REFFAC) {
    //FORMA DE PAGO
    $sql = "select   DISTINCT A.REFFAC, h.desconpag as forma, c.destippag as pago,
           d.monpag as monto,g.banco as banco,
           d.numero as numero
           from fafactur a
           left outer join faconpag h on (a.codconpag=h.id)
           left outer join faforpag d on (a.reffac=d.reffac)
           left outer join faallbancos g on (d.nomban=g.ctaban)
           left outer join fatippag c on (d.tippag=c.id),
           facliente b,
           faartfac f
           where
           a.codcli=b.codpro and
           f.reffac=a.reffac and
           a.reffac = '" . $REFFAC . "'
           order by A.reffac  ";
    //H::PrintR($sql);exit;
    return $this->select($sql);
  }

  function sqlpdes($REFFAC) {
    //DESCRIPCION DEL PADRE DEL ARTICULO
    $sql = "select distinct substr(e.codart,0,8) as codart, substr(f.codart,0,8) as codart2,  e.desart as articulo
	    from
           caregart e,
           faartfac f
           where
           length(rtrim(e.codart))=7 and
           substr(e.codart,0,8)=substr(f.codart,0,8) and
           f.reffac = '" . $REFFAC . "'
           ORDER BY CODART ";
    //H::PrintR($sql);
    // exit;
    return $this->select($sql);
  }

  function sqlmontos($var, $reffac) {
    if ($var == 'T') {
      $sql = "select monfac as total from fafactur where reffac='$reffac'--total";
//	$sql = "select sum(precio*cantot) as total from faartfac where reffac='$reffac'--total";      
//print "<pre>".$sql;exit;
    } else if ($var == 'R') {
      //$sql = "select min(a.monrgo) as montorecargo from fargoart a, farecarg b where refdoc='$reffac' and a.codrgo=b.codrgo --recargo";
      $sql = "select min(b.nomrgo) as nomrgo ,sum(a.monrgo) as montorecargo from fargoart a, farecarg b where refdoc='$reffac' and a.codrgo=b.codrgo --recargo";
      // print "<pre>".$sql;exit;
    } else if ($var == 'BI1') {
      $sql =
/* "select sum(a.precio*a.cantot) as baseimponible from faartfac a
                    inner join fargoart b on (a.codart=b.codart)
                    inner join farecarg c on (b.codrgo=c.codrgo)  where reffac='$reffac' and A.monrgo>0
                    and b.codrgo='0001' --base imponible iva 12%";*/
"select  sum(precio*cantot) as baseimponible from faartfac a, fargoart b where a.reffac='$reffac' and a.monrgo>0 and a.reffac = b.refdoc and b.codrgo='0001' and a.codart=b.codart --base imponible";
//print "<pre>".$sql;exit;

    } else if ($var == 'BI2') {
      $sql =
/* "select sum(a.precio*a.cantot) as baseimponible from faartfac a
                    inner join fargoart b on (a.codart=b.codart)
                    inner join farecarg c on (b.codrgo=c.codrgo)  where reffac='$reffac' and A.monrgo>0
                    and b.codrgo='0002' --base imponible iva 8%";*/
      // print "<pre>".$sql;exit;
 //     "select  sum(precio*cantot)-sum(mondes) as baseimponible from faartfac where reffac='$reffac' and monrgo>0 --base imponible";
"select  sum(precio*cantot) as baseimponible from faartfac a, fargoart b where a.reffac='$reffac' and a.monrgo>0 and a.reffac = b.refdoc and b.codrgo='0002' and a.codart=b.codart --base imponible";
//print "<pre>".$sql;exit;

    } else if ($var == 'TE') {
      $sql = "select  sum(precio*cantot) as totalexento from faartfac where reffac='$reffac' and (monrgo=0 or monrgo is null)--total exento";
    } else if ($var == 'TD') {
      $sql = "select  sum(mondes) as totaldcto from faartfac where reffac='$reffac'";
    }
    return $this->select($sql);
  }

}

?>
