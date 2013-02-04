<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarliscalporrub extends baseClases {

    function SQLp($rubdes,$rubhas,$empdes,$emphas,$catdes,$cathas,$nivdes,$nivhas,$ciudes,$ciuhas,$prodes,$prohas,$fordes,$forhas,$gru1,$gru2,$fecdes,$fechas,$status,$tipvia) {

        
        if($status!='G')
        {
            $sqlstatus="h.status='$status' and";
        }else
        {
            $sqlstatus='';
        }
        if($tipvia!='G')
        {
            $sqltipo="a.tipvia='$tipvia' and";
        }else
        {
            $sqltipo='';
        }

        $sql="select distinct a.numsol, to_char(a.fecsol,'dd/mm/yyyy') as fecsol, a.tipvia, a.codemp, b.nomemp, a.codcat, c.nomcat, a.codniv, d.desniv,
                a.dessol,a.codciu, e.nomciu, f.codproced, f.desproced,g.codfortra,g.desfortra,        
                to_char(a.fecdes,'dd/mm/yyyy') as fecdes,to_char(fechas,'dd/mm/yyyy') as fechas,a.numdia,
                h.numcal,to_char(h.feccal,'dd/mm/yyyy') as feccal,h.diaconper,h.diasinper,h.refcom,
                case when h.status='A' then 'APROBADA' else 'POR APROBAR' end as status,
                sum(i.montot) as monto,i.codrub,j.desrub as nomrub
                from viasolviatra a left outer join viaciudad e on (a.codciu>='$ciudes' and a.codciu<='$ciuhas' and a.codciu=e.codciu),
                nphojint b, npcatpre c, viadefniv d,
                viadefproced f, viadeffortra g,
                viacalviatra h, viadetcalviatra i, viadefrub j
                where
                i.codrub>='$rubdes' and
                i.codrub<='$rubhas' and
                a.codemp>='$empdes' and
                a.codemp<='$emphas' and
                a.codcat>='$catdes' and
                a.codcat<='$cathas' and
                a.codniv>='$nivdes' and
                a.codniv<='$nivhas' and                
                a.codproced>='$prodes' and
                a.codproced<='$prohas' and
                a.codfortra>='$fordes' and
                a.codfortra<='$forhas' and
                a.fecsol>=to_date('$fecdes','dd/mm/yyyy') and
                a.fecsol<=to_date('$fechas','dd/mm/yyyy') and
                $sqlstatus
                $sqltipo
                a.numsol=h.refsol and
                a.codemp=b.codemp and
                a.codcat=c.codcat and
                a.codniv=d.codniv and                
                a.codproced=f.codproced and
                a.codfortra=g.codfortra and
                i.codrub=j.codrub and
                i.numcal=h.numcal
                group by
                a.numsol, to_char(a.fecsol,'dd/mm/yyyy'), a.tipvia, a.codemp, b.nomemp, a.codcat, c.nomcat, a.codniv, d.desniv,
                a.dessol,a.codciu, e.nomciu, f.codproced, f.desproced,g.codfortra,g.desfortra,
                to_char(a.fecdes,'dd/mm/yyyy') ,to_char(fechas,'dd/mm/yyyy'),a.numdia,
                h.numcal,to_char(h.feccal,'dd/mm/yyyy'),h.diaconper,h.diasinper,h.refcom,
                case when h.status='A' then 'APROBADA' else 'POR APROBAR' end,
                i.codrub,j.desrub
                order by i.codrub, h.numcal
            ";
        #H::printr($sql);exit;
        return $this->select($sql);
    }

}
?>
