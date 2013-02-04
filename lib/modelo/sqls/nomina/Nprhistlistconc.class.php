<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprhistlistconc extends baseClases
{

    function sqlp($pf_10, $codempdes, $codemphas, $codcardes, $codcarhas, $codcondes, $codconhas, $especial, $tipnomesp, $fecreg1, $fecreg2, $codnom)
    {
        if ($especial == 'S')
        {
            $especial = " A.especial = 'S' AND
                              A.CODNOMESP = '$tipnomesp' AND ";
        }
        else
        {
            if ($especial == 'N')
                $especial = " A.especial = 'N' AND";
        }
        if ($pf_10 == 't')
        {
            $sql = "SELECT DISTINCT A.CODEMP, D.NOMCON, A.CODCON,sum(A.monto) as saldo, A.CODNOM, C.NOMEMP, C.CEDEMP, C.CODBAN, E.NOMBAN,
							 D.OPECON, D.CODCON, D.IMPCPT,cast(REPLACE(c.cedemp,'.', '') as int)
							FROM NPhiscon A, NPCARGOS B,  NPDEFCPT D, NPHOJINT C LEFT OUTER JOIN NPBANCOS E ON (C.CODBAN=E.CODBAN)
							WHERE
							A.CODCON=D.CODCON AND
							A.CODEMP=C.CODEMP AND
							A.CODCAR=B.CODCAR AND
							C.CODBAN=E.CODBAN AND
							A.monto<>0.00 AND
							--D.CONACT='S' AND
							--D.IMPCPT='S' AND
							A.CODEMP >= '$codempdes' AND A.CODEMP <= '$codemphas' AND
							A.CODCAR >= '$codcardes' AND A.CODCAR <= '$codcarhas' AND
							A.CODCON >= '$codcondes' AND A.CODCON <= '$codconhas' AND ".$especial."
							A.fecnom >= to_date('$fecreg1','dd/mm/yyyy') AND A.fecnom <= to_date('$fecreg2','dd/mm/yyyy') AND
							A.CODNOM = '$codnom'
							group by
							A.CODEMP,d.NOMCON,A.CODCON,A.CODNOM,C.NOMEMP,C.CEDEMP,C.CODBAN,E.NOMBAN,D.OPECON,D.CODCON,D.IMPCPT
							ORDER BY A.CODCON,cast(REPLACE(c.cedemp,'.', '') as int ) ";
    }
    else
    {
        $sql = "SELECT DISTINCT A.CODEMP, D.NOMCON, A.CODCON,sum(A.monto) as saldo, A.CODNOM, C.NOMEMP, C.CEDEMP, C.CODBAN, E.NOMBAN,
							D.OPECON, D.CODCON, D.IMPCPT,cast(REPLACE(c.cedemp,'.', '') as int)
							FROM NPhiscon A, NPCARGOS B,  NPDEFCPT D, NPHOJINT C LEFT OUTER JOIN NPBANCOS E ON (C.CODBAN=E.CODBAN)
							WHERE
							A.CODCON=D.CODCON AND
							A.CODEMP=C.CODEMP AND
							A.CODCAR=B.CODCAR AND
							C.CODBAN=E.CODBAN AND ".$especial."
							A.monto<>0.00 AND
							--D.CONACT='S' AND
							--D.IMPCPT='S' AND
							A.CODEMP >= '$codempdes' AND A.CODEMP <= '$codemphas' AND
							A.CODCAR >= '$codcardes' AND A.CODCAR <= '$codcarhas' AND
							A.CODCON >= '$codcondes' AND A.CODCON <= '$codconhas' AND
							A.fecnom >= to_date('$fecreg1','dd/mm/yyyy') AND A.fecnom <= to_date('$fecreg2','dd/mm/yyyy') AND
							A.CODNOM = '$codnom' AND
							D.OPECON = '$pf_10'
							group by
							A.CODEMP,d.NOMCON,A.CODCON,A.CODNOM,C.NOMEMP,C.CEDEMP,C.CODBAN,E.NOMBAN,D.OPECON,D.CODCON,D.IMPCPT
							ORDER BY A.CODCON,cast(REPLACE(c.cedemp,'.', '') as int )";
}
//print("<pre>".'$sql'.$sql);exit;
return $this->select($sql);
}

function sql2($codnom)
{
    $sql = "SELECT NOMNOM as nombre FROM NPNOMINA WHERE
			 codnom='$codnom'";
return $this->select($sql);
}


}
?>
