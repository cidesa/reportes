<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisrel extends baseClases {

    function SQLp($empdes,$emphas,$catdes,$cathas,$ciudes,$ciuhas,$gru1,$gru2,$fecdes,$fechas) {

        $sqlgru1="";
        if($gru1=='E')
        {
            $sqlgru1="a.codemp,";
        }elseif($gru1=='C')
        {
            $sqlgru1="a.codcat,";
        }elseif($gru1=='D')
        {
            $sqlgru1="a.codciu,";
        }
        $sqlgru2="";
        if($gru2=='E')
        {
            $sqlgru2="a.codemp,";
        }elseif($gru2=='C')
        {
            $sqlgru2="a.codcat,";
        }elseif($gru2=='D')
        {
            $sqlgru2="a.codciu,";
        }
        
        $sql="select distinct a.numsol, to_char(a.fecsol,'dd/mm/yyyy') as fecsol, a.tipvia, a.codemp, b.nomemp, a.codcat, c.nomcat, a.codniv, d.desniv,
                a.dessol,a.codciu, e.nomciu, f.codproced, f.desproced,g.codfortra,g.desfortra,        
                to_char(a.fecdes,'dd/mm/yyyy') as fecdes,to_char(fechas,'dd/mm/yyyy') as fechas,a.numdia,
                h.numrel,to_char(h.fecrel,'dd/mm/yyyy') as fecrel,h.refcom,h.desrel,h.monto
                from viasolviatra a left outer join viaciudad e on (a.codciu>='$ciudes' and a.codciu<='$ciuhas' and a.codciu=e.codciu),
                nphojint b, npcatpre c, viadefniv d,
                viadefproced f, viadeffortra g,
                (select x.numrel,x.fecrel,x.refcom,x.desrel,sum(montonet) as monto,min(z.refsol) as refsol from viarelvia x, viadetrelvia z
		where
		x.numrel=z.numrel
		group by
		x.numrel,x.fecrel,x.refcom,x.desrel
		) h
                where
                a.codemp>='$empdes' and
                a.codemp<='$emphas' and
                a.codcat>='$catdes' and
                a.codcat<='$cathas' and        
                h.fecrel>=to_date('$fecdes','dd/mm/yyyy') and
                h.fecrel<=to_date('$fechas','dd/mm/yyyy') and
                a.numsol=h.refsol and
                a.codemp=b.codemp and
                a.codcat=c.codcat and
                a.codniv=d.codniv and                
                a.codproced=f.codproced and
                a.codfortra=g.codfortra
                order by $sqlgru1 $sqlgru2 h.numrel
            ";
        #H::printr($sql);exit;
        return $this->select($sql);
    }

}
?>
