<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarlisext extends baseClases {

    function SQLp($empdes,$emphas,$catdes,$cathas,$nivdes,$nivhas,$ciudes,$ciuhas,$prodes,$prohas,$fordes,$forhas,$gru1,$gru2,$fecdes,$fechas,$status,$tipvia) {

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
        }elseif($gru1=='P')
        {
            $sqlgru1="f.codproced,";
        }elseif($gru1=='F')
        {
            $sqlgru1="g.codfortra,";
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
        }elseif($gru2=='P')
        {
            $sqlgru2="f.codproced,";
        }elseif($gru2=='F')
        {
            $sqlgru2="g.codfortra,";
        }
        
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

        $sql="select distinct i.numcal as numsol, to_char(a.fecsol,'dd/mm/yyyy') as fecsol, a.tipvia, a.codemp, b.nomemp, a.codcat, c.nomcat, a.codniv, d.desniv,
                a.dessol,a.codciu, e.nomciu, f.codproced, f.desproced,g.codfortra,g.desfortra,        
                to_char(a.fecdes,'dd/mm/yyyy') as fecdes,to_char(fechas,'dd/mm/yyyy') as fechas,a.numdia,
                h.numext as numcal,to_char(h.fecext,'dd/mm/yyyy') as feccal,h.diaconper,h.diasinper,h.refcom,
                case when h.status='A' then 'APROBADA' else 'POR APROBAR' end as status,
                (select sum(montot) from viadetextviatra where numext=h.numext) as monto
                from viasolviatra a left outer join viaciudad e on (a.codciu>='$ciudes' and a.codciu<='$ciuhas' and a.codciu=e.codciu),
                nphojint b, npcatpre c, viadefniv d,
                viadefproced f, viadeffortra g,
                viacalviatra i,
                viaextviatra h
                where
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
                h.fecext>=to_date('$fecdes','dd/mm/yyyy') and
                h.fecext<=to_date('$fechas','dd/mm/yyyy') and
                $sqlstatus
                $sqltipo
                a.numsol=i.refsol and
                i.numcal=h.refcal and
                a.codemp=b.codemp and
                a.codcat=c.codcat and
                a.codniv=d.codniv and                
                a.codproced=f.codproced and
                a.codfortra=g.codfortra
                order by $sqlgru1 $sqlgru2 h.numext
            ";
        #H::printr($sql);exit;
        return $this->select($sql);
    }

}
?>
