<?php

require_once("../../lib/modelo/baseClases.class.php");

class Cprprecodpre extends baseClases {

  function sqlp($codpredesde, $codprehasta, $fecprcdesde, $fecprchasta, $tipprcdesde, $tipprchasta, $comodin) {
    $sql = "

        select a.*,b.desprc,b.tipprc,b.fecprc, (a.monimp+a.monaju) as montotaju, c.nompre FROM cpimpprc a, cpprecom b, cpdeftit c
                where 
                a.refprc=b.refprc
                and a.codpre=c.codpre
                and a.codpre>='".$codpredesde."'
                and a.codpre<='". $codprehasta ."'
                order by a.codpre,b.fecprc,a.refprc

";
    //print($sql);exit;
    return $this->select($sql);
  }

}

?>