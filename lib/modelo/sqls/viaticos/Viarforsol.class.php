<?php

require_once("../../lib/modelo/baseClases.class.php");

class Viarforsol extends baseClases {

    function SQLp($numdes,$numhas,$empdes,$emphas,$catdes,$cathas,$nivdes,$nivhas,$ciudes,$ciuhas,$prodes,$prohas,$fordes,$forhas,$fecdes,$fechas,$tipvia) {

        if($tipvia!='G')
        {
            $sqltipo="a.tipvia='$tipvia' and";
        }else
        {
            $sqltipo='';
        }

        $sql="select distinct a.numsol, to_char(a.fecsol,'dd/mm/yyyy') as fecsol, a.tipvia, a.codemp, b.nomemp, a.codcat, c.nomcat, a.codniv, d.desniv,
                a.dessol,a.codciu, e.nomciu,i.nomest,j.nompai,f.codproced, f.desproced,g.codfortra,g.desfortra,
                case when a.status='A' then 'APROBADA' else 'POR APROBAR' end as status,
                to_char(a.fecdes,'dd-mm-yyyy') as fecdes,to_char(fechas,'dd-mm-yyyy') as fechas,a.numdia,
                a.codempaco,(select nomemp from nphojint where codemp=a.codempaco) as nomempaco,
                             a.codempaut,(select nomemp from nphojint where codemp=a.codempaut) as nomempaut
                                from viasolviatra a left outer join viaciudad e on (a.codciu>='$ciudes' and a.codciu<='$ciuhas' and a.codciu=e.codciu)
                left outer join viaestado i on (e.codest=i.codest)
                left outer join viapais j on (e.codpai=j.codpai),
                nphojint b, npcatpre c, viadefniv d,
                viadefproced f, viadeffortra g
                where
                a.numsol>='$numdes' and
                a.numsol<='$numhas' and
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
                $sqltipo
                a.codemp=b.codemp and
                a.codcat=c.codcat and
               
                
                a.codniv=d.codniv and                
                a.codproced=f.codproced and
                a.codfortra=g.codfortra
                order by a.numsol
            ";
        //H::printr($sql);exit;
        return $this->select($sql);
    }

}
?>
