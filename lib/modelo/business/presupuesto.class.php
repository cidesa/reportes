<?php

require_once("../../lib/modelo/baseClases.class.php");

class Presupuesto extends baseClases {

  public static function catalogo_codprePrerasiini($objhtml, $orden) {
    if ($orden == 'A') {
      $sql = "select distinct a.codpre,b.nompre from cpdeftit b,cpdisfuefin a where ( a.codpre like '%V_0%' AND b.nompre like '%V_1%' ) and a.codpre=b.codpre order by a.codpre asc";
    } else {
      $sql = "select a.codpre,b.nompre from cpdeftit b, cpdisfuefin a where ( a.codpre like '%V_0%' AND b.nompre like '%V_1%' ) and a.codpre=b.codpre order by codpre desc";
    }

    $catalogo = array(
        $sql,
        array('Código Presupuestario', 'Nombre'),
        array($objhtml),
        array('codpre'),
        100
    );

    return $catalogo;
  }

  public static function catalogo_cpcompro($objhtml) {
    $sql = "select distinct(refcom) as refcom, descom from cpcompro where ( refcom like '%V_0%' AND descom like '%V_1%' ) order by refcom asc";

    $catalogo = array(
        $sql,
        array('Código de Compromiso', 'Descripcion'),
        array($objhtml),
        array('refcom'),
        100
    );

    return $catalogo;
  }

  function catalogo_opbenefi_cedrif($objhtml) {
    $sql = "select cedrif, nomben  FROM OPBENEFI WHERE ( cedrif like '%V_0%' and nomben like '%V_1%'  ) order by cedrif asc";

    $catalogo = array(
        $sql,
        array('Cedula', 'Nombre'),
        array($objhtml),
        array('cedrif'),
        100
    );

    return $catalogo;
  }

  function catalogo_cpimpprc_codpre($objhtml) {
    $sql = "select distinct a.codpre, b.nompre FROM CPIMPPRC a inner join cpdeftit b on a.codpre=b.codpre WHERE ( a.codpre like '%V_0%' AND b.nompre like '%V_1%' ) order by a.codpre asc";

    $catalogo = array(
        $sql,
        array('Codigo', 'Descripción'),
        array($objhtml),
        array('codpre'),
        100
    );

    return $catalogo;
  }

  public static function catalogo_cpdocprc($objhtml) {
    $sql = "select tipprc, nomext from cpdocprc where ( tipprc like '%V_0%' AND nomext like '%V_1%' ) order by tipprc asc";

    $catalogo = array(
        $sql,
        array('Código', 'Descripcion'),
        array($objhtml),
        array('tipprc'),
        100
    );

    return $catalogo;
  }

}

?>
