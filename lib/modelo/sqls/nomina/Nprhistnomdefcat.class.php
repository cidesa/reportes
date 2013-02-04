<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistnomdefcat extends baseClases
{

    function sql($especial,$tipnomesp1,$tipnomesp2,$tipnom,$codempdes,$codemphas,$codcatdes,$codcathas,$codcardes,$codcarhas,$codcondes,$codconhas,$fechades,$fechahas)
    {
        if ($especial == 'S')
        {
            $especial = " G.especial = 'S' AND
                    G.CODNOMESP >= '$tipnomesp1' AND
                    G.CODNOMESP <= '$tipnomesp2' AND ";
        }
        else
        {
            if ($especial == 'N')
                $especial = " G.especial = 'N' AND";
        }
    
        $sql = "SELECT
                          distinct C.CODEMP as codemp,
                          to_char(C.FECRET,'dd/mm/yyyy') as fecret,
                          C.NOMEMP as nomemp,
                          to_char(C.FECING,'dd/mm/yyyy') as fecing,
                          C.NUMCUE as CUENTA_BANCO,
                          g.CODCAT as CODCAT,
                          D.nomcat as nomcat,
                          C.CEDEMP as cedemp,
                          g.CODCAR as CODCAR,
                          a.NOMCAR as nomcar,
                          (CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
                          G.CODCAR as codcargo,
                          G.CODCON as codcon,
                          G.NOMCON AS NOMCON,-- G.MONTO as ASIGNA
            							(CASE WHEN H.OPECON='A' THEN coalesce(sum(G.MONTO),0) ELSE 0 END) as ASIGNA,
            	(CASE WHEN H.OPECON='D' THEN coalesce(sum(G.MONTO),0) ELSE 0 END) as DEDUC,
            	(CASE WHEN H.OPECON='P' THEN coalesce(sum(G.MONTO),0) ELSE 0 END) as APORTE, cast(REPLACE(c.cedemp,'.', '') as int )
                        FROM
                          NPHOJINT C,
                          NPCATPRE D,
                          nphiscon G,
                          NPDEFCPT H, npcargos A
                        WHERE
                          g.CODNOM = '$tipnom' AND
                          C.CODEMP>= '$codempdes' AND
                          C.CODEMP <= '$codemphas' AND
                          g.CODCAT>= '$codcatdes' AND
                          g.CODCAT <= '$codcathas' AND
                          g.CODCAR>= '$codcardes' AND
                          g.CODCAR <= '$codcarhas' AND
                          G.CODCON>='$codcondes' AND
                          G.CODCON<='$codconhas' AND ".$especial."
                          g.codcar=a.codcar and
                       --   B.STATUS='V' AND
                          H.IMPCPT='S' AND
                          g.CODEMP=C.CODEMP AND
                          g.CODCAT=D.CODCAT AND
                      --    B.CODEMP=G.CODEMP AND
                     --     B.CODCAR=G.CODCAR AND
                     --     B.CODNOM=G.CODNOM AND
                          G.CODCON=H.CODCON and
            		      g.fecnomdes>=to_date('$fechades','dd/mm/yyyy') and
            			  g.fecnom<=to_date('$fechahas','dd/mm/yyyy')
            				GROUP BY
            				C.CODEMP ,c.cedemp,
            				C.FECRET,
            				C.NOMEMP ,
            				H.OPECON,c.fecing,c.numcue,g.codcat,d.nomcat,g.codcar,a.nomcar,c.staemp,g.codcar,
            				g.codcon,g.nomcon,g.monto
                        ORDER BY
                          g.codcat,cast(REPLACE(c.cedemp,'.', '') as int )";
    //print"<pre> sql=".$sql;exit;
    return $this->select($sql);
    }
    function rs($tipnom)
    {
        $sql = "select upper(nomnom) as nombre from NPNOMINA where codnom='$tipnom'";
    //print"<pre> sql=".$sql;exit;
    return $this->select($sql);
    }
}
?>
