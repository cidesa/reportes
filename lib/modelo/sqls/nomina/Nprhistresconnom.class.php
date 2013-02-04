<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistresconnom extends baseClases
{

    function sql($especial, $tipnomesp1, $tipnomesp2, $con1, $con2, $tipcon, $fechades, $fechahas)
    {
        if ($especial == 'S')
        {
            $nomespecial = " a.codnomesp>='".$tipnomesp1."' and a.codnomesp<='".$tipnomesp2."' and";
        }

        $sql = " SELECT DISTINCT(A.CODCON), B.NOMCON, A.CODNOM as codnom , B.OPECON as asided,
            							SUM(CASE WHEN A.MONTO=0 THEN 0 ELSE 1 END ) AS CANT,
            							SUM(CASE WHEN B.OPECON='A' THEN A.MONTO ELSE 0 END) AS ASIGNA,
            							SUM(CASE WHEN B.OPECON='D' THEN A.MONTO ELSE 0 END) AS DEDUC ,
            							SUM(CASE WHEN (B.OPECON='P' and A.CODCON <> 'P33' and A.CODCON <> 'P34' and A.CODCON <> 'P35' and A.CODCON <> 'P36'  ) THEN A.MONTO ELSE 0 END ) AS APORTE ,
            							B.IMPCPT, b.codpar, C.NOMNOM
            							FROM NPHISCON A, NPDEFCPT B, NPNOMINA C
            
            							WHERE
            							 A.CODNOM=C.CODNOM AND
            							A.CODNOM >= '$con1' AND
            							A.CODNOM <= '$con2' AND
                                        A.especial='$especial' AND ".$nomespecial."
            							A.MONTO > 0  AND
            							B.OPECON LIKE '$tipcon' AND
            							B.CODCON = A.CODCON and
            						      a.fecnom>=to_date('$fechades','dd/mm/yyyy') and
            							 a.fecnom<=to_date('$fechahas','dd/mm/yyyy')
            							GROUP BY A.CODCON,B.NOMCON,A.CODNOM,B.OPECON, B.IMPCPT,b.codpar, C.NOMNOM
            							ORDER BY A.CODNOM, B.OPECON, A.CODCON";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }

    function profec($codigo)
    {
        $sql = "select to_char(profec,'dd/mm/yyyy') as profec, to_char(ultfec,'dd/mm/yyyy') as ultfec from npnomina where codnom = '$codigo'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }

    function cantidad($codigo,$tbgasided,$tbgcodcon)
    {
        $sql = "SELECT COUNT(DISTINCT(CODEMP)) as numero FROM NPNOMCAL WHERE codnom='$codigo' and asided='$tbgasided' and codcon = '$tbgcodcon')";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>
