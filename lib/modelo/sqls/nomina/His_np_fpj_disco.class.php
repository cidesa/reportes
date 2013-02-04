<?php
require_once ("../../lib/modelo/baseClases.class.php");

class His_np_fpj_disco extends baseClases
{

    function sql($especial,$tipnomesp,$codempdes,$codemphas,$fechades,$fechahas,$tipnomdes,$tipnomhas)
    {
        if ($especial == 'S')
        {
            $especial = " h.especial = 'S' AND 	h.CODNOMESP = '$tipnomesp' AND ";
        }
        else
        {
            if ($especial == 'N')
                $especial = " h.especial = 'N' AND ";
            else
            if ($especial == 'T')
                $especial = "";
        }

        $sql = "SELECT
        						DISTINCT
        						trim(H.CODEMP) as CODEMP,
        						A.CODTIPAPO,
        						A.DESTIPAPO,
        						A.PORAPO,
        						A.PORRET,
        						B.CODNOM AS CODNOMAPO,
        						SUM(H.monto) AS CF_MONRETENCION,
        						C.NOMNOM,
        						H.CODCAR as codcar,
        						to_char(E.FECING,'dd/mm/yyyy') as FECING,
        						E.NOMEMP
        						FROM
        						 NPTIPAPORTES A,
        						 NPCONTIPAPORET B,
        						 NPNOMINA C,
        						   npcargos F,
        						   NPHOJINT E,
        						   NPhiscon H
        						WHERE
        						H.codcar=F.codcar AND
        						E.CODEMP=H.CODEMP AND
        						E.CODEMP >=  '$codempdes' AND
        						E.CODEMP <= '$codemphas' AND 	 ".$especial."
        						H.CODCON = B.CODCON AND
        						upper(B.TIPO)='R'  AND
        						H.FECNOM>=to_date('$fechades','dd/mm/yyyy') AND
        						H.FECNOM<=to_date('$fechahas','dd/mm/yyyy') AND
        						B.CODNOM=H.CODNOM AND
        						A.CODTIPAPO=B.CODTIPAPO AND
        						B.CODNOM=C.CODNOM AND
        						A.CODTIPAPO=B.CODTIPAPO AND
        						A.CODTIPAPO='0004' AND
        						B.CODNOM>='$tipnomdes' AND
        						B.CODNOM<='$tipnomhas'
        						GROUP BY
        						A.CODTIPAPO,H.CODEMP,H.CODCAR,E.NOMEMP,E.FECING,A.DESTIPAPO,A.PORAPO,A.PORRET,C.NOMNOM,B.CODNOM,H.monto
        						ORDER BY B.CODNOM,E.nomEMP";
		    //print"<pre> $sql=".$sql;
		    return $this->select($sql);
		}
		function sql2($tbcodemp,$tbcodcar,$fechades,$fechahas)
		{
		    $sql = "SELECT
														coalesce(SUM(MONTO),0) as VALOR
													FROM
														NPHISCON A,
														NPCONSALINT B
													WHERE
													  CODEMP='$tbcodemp' AND
													  CODCAR='$tbcodcar' AND
													  A.CODCON=B.CODCON and
													  A.FECNOM >= to_date('$fechades','dd/mm/yyyy') AND
													  A.FECNOM <= to_date('$fechahas','dd/mm/yyyy')";
		//print"<pre> $sql=".$sql;
		return $this->select($sql);
		}
		
        function sql3($tbcodemp,$fechades,$fechahas)
        {
            $sql = "SELECT coalesce(SUM(MONTO),0) as ELMONTO FROM NPHISCON A, NPHOJINT B, NPCONTIPAPORET C  WHERE trim(C.CODTIPAPO)='0004' AND  A.CODNOM=C.CODNOM AND A.CODCON=C.CODCON AND upper(C.TIPO)='A' AND  B.CODEMP=A.CODEMP AND  B.CODEMP='$tbcodemp' AND A.FECNOM >= to_date('$fechades','dd/mm/yyyy') AND A.FECNOM <= to_date('$fechahas','dd/mm/yyyy')";
            //print"<pre> $sql=".$sql;
            return $this->select($sql);
        }
}
?>
