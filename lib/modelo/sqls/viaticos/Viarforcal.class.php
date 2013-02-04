<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarforcal extends baseClases {

    function SQLp($numdes,$numhas,$empdes,$emphas,$catdes,$cathas,$nivdes,$nivhas,$ciudes,$ciuhas,$prodes,$prohas,$fordes,$forhas,$fecdes,$fechas,$tipvia) {

        if($tipvia!='G')
        {
            $sqltipo="a.tipvia='$tipvia' and";
        }else
        {
            $sqltipo='';
        }

        $sql="select distinct a.numsol, to_char(a.fecsol,'dd/mm/yyyy') as fecsol, a.tipvia, a.codemp, b.nomemp, a.codcat, c.nomcat, a.codniv, d.desniv,
                a.dessol,a.codciu, e.nomciu,k.nompai,i.nomest,f.codproced, f.desproced,g.codfortra,g.desfortra,
                case when a.status='A' then 'APROBADA' else 'POR APROBAR' end as status,
                to_char(a.fecdes,'dd-mm-yyyy') as fecdes,to_char(fechas,'dd-mm-yyyy') as fechas,a.numdia,
                a.codempaco,(select nomemp from nphojint where codemp=a.codempaco) as nomempaco,                
                j.numcal, to_char(j.feccal,'dd/mm/yyyy') as feccal,j.observaciones
                from viasolviatra a left outer join viaciudad e on (a.codciu>='$ciudes' and a.codciu<='$ciuhas' and a.codciu=e.codciu)
                left outer join viaestado i on (e.codest=i.codest)
                left outer join viapais k on (e.codpai=k.codpai),
                nphojint b, npcatpre c, viadefniv d,
                viadefproced f, viadeffortra g, viacalviatra j
                where
                j.numcal>='$numdes' and
                j.numcal<='$numhas' and
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
                j.feccal>=to_date('$fecdes','dd/mm/yyyy') and
                j.feccal<=to_date('$fechas','dd/mm/yyyy') and
                $sqltipo
                a.numsol=j.refsol and
                a.codemp=b.codemp and
                a.codcat=c.codcat and
                a.codniv=d.codniv and                
                a.codproced=f.codproced and
                a.codfortra=g.codfortra
                order by j.numcal
            ";
        //H::printr($sql);exit;
        return $this->select($sql);
    }

    function sqlvia($numvia,$tipvia='N')
    {
        if($tipvia=='I')
            $sql="select *,b.valdolar from (
                select 1 as ord,a.numcal,a.codrub,
                case when tipo='I1' then 'VIATICO DIARIO INTERNACIONAL'
                when tipo='I2' then 'PRIMA ADICIONAL 100%'
                when tipo='I3' then 'PRIMA SUPLEMENTARIA 30%'
                else '' end as desrub,
                a.numdia,a.mondia,a.montot from viadetcalviatra a
                where
                a.codrub='VI'
                union all
                select 3 as ord, a.numcal,a.codrub,b.desrub,a.numdia,a.mondia,a.montot from viadetcalviatra a, viadefrub b
                where a.codrub=b.codrub and
                a.tipo=''
                union all
                select 2 as ord, a.numcal,a.codrub,b.destiptra,a.numdia,a.mondia,a.montot from viadetcalviatra a, viadeftiptra b
                where a.tipo=b.codtiptra and
                a.tipo<>'')a, viadefgen b
                where
                a.numcal='$numvia'
                order by ord";
        else
            $sql="select *,b.valdolar from (
                select a.numcal,a.codrub,b.desrub,a.numdia,a.mondia,a.montot from viadetcalviatra a, viadefrub b
                where a.codrub=b.codrub and
                a.tipo=''
                union all
                select a.numcal,a.codrub,b.destiptra,a.numdia,a.mondia,a.montot from viadetcalviatra a, viadeftiptra b
                where a.tipo=b.codtiptra and
                a.tipo<>'')a, viadefgen b
                where
                a.numcal='$numvia'
                order by a.codrub";
        return $this->select($sql);
    }

}
?>
