<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarforrel extends baseClases {

    function SQLp($numdes,$numhas,$empdes,$emphas,$catdes,$cathas,$pardes,$parhas,$ciudes,$ciuhas,$fecdes,$fechas) {


        $sql="select a.numrel, to_char(a.fecrel,'dd/mm/yyyy') as fecrel, a.tipcom,e.nomext,a.desrel, b.codemp, c.nomemp,
            b.numfac, to_char(b.fecfac,'dd/mm/yyyy') as fecfac, b.montonet, b.montorec,b.codcat,b.codpar,b.refsol
            from viarelvia a, viadetrelvia b, nphojint c, viasolviatra d, cpdoccom e
            where
            a.numrel>='$numdes' and
            a.numrel<='$numhas' and
            b.codemp>='$empdes' and
            b.codemp<='$emphas' and
            b.codcat>='$catdes' and
            b.codcat<='$cathas' and
            b.codpar>='$pardes' and
            b.codpar<='$parhas' and
            d.codciu>='$ciudes' and
            d.codciu<='$ciuhas' and
            a.fecrel>=to_date('$fecdes','dd/mm/yyyy') and
            a.fecrel<=to_date('$fechas','dd/mm/yyyy') and
            a.tipcom=e.tipcom and
            b.codemp=c.codemp and
            b.refsol=d.numsol and
            a.numrel=b.numrel
            ";
        #H::printr($sql);exit;
        return $this->select($sql);
    }
}
?>
