<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprpres5dhist extends baseClases
{
    function sql($codtipapodes, $tipnom, $tipnom2)
    {
        $sql = "SELECT DISTINCT A.CODTIPAPO as codtipapo,A.DESTIPAPO as destipapo,(A.PORAPO) as porapo,(A.PORRET) as porret,B.CODNOM as CODNOMAPO
						FROM NPTIPAPORTES A,NPCONTIPAPORET B  WHERE
						A.CODTIPAPO=B.CODTIPAPO AND
						A.CODTIPAPO='$codtipapodes' AND
						B.CODNOM>='$tipnom' and B.CODNOM<='$tipnom2'";

        return $this->select($sql);
    }

    function sql2($especial,$tipnom,$tipnom2,$codempdes,$codemphas,$catdes,$cathas,$codtipapodes,$fecreg1,$fecreg2)
    {
    	
        if ($this->especial == 'S')
        {
            $especial = " a.especial = 'S' AND
        		A.CODNOMESP = '$tipnomesp' AND
         ";
            $especial2 = " a.especial = 'S' AND
        		A.CODNOMESP = '$tipnomesp' AND
         ";
        }
        else
        {
            if ($especial == 'N')
                $especial = " a.especial = 'N' AND --A.CODCON<>'A03' AND";
            else
            if ($especial == 'T')
                $especial = "A.CODCON<>'A03' AND";
        }
        $sql = "SELECT
        						DISTINCT
        						A.CODEMP as codemp,
        						B.CEDEMP as cedemp,
        						A.CODNOM,
        						A.CODCAR as codcar,
        						SUM(A.monto) as MONTO,
        						to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') as  FECING,
        						B.NOMEMP as nomemp,
        						B.NACEMP,
        						to_char(B.FECNAC,'dd/mm/yyyy') as fecnac,
        						B.SEXEMP as sexemp,
        						B.CODNIV, cast(REPLACE(b.cedemp,'.', '') as int )
        						 FROM
        						   nphiscon  A,NPHOJINT B, npdefcpt e, npconsalint d
        						 WHERE
        						 ".$especial."
        						B.CODEMP = A.CODEMP and A.codcon = d.codcon and A.codnom = d.codnom
        						--AND e.opecon='A'
        						AND  A.CODNOM >= '$tipnom' and  A.CODNOM <= '$tipnom2'
        						AND  B.CODEMP >=  '$codempdes'
        						AND  B.CODEMP <= '$codemphas'
        						and a.codcat >= '$catdes'
        						and a.codcat <= '$cathas' AND
        						A.fecnom >= to_date('$fecreg1','dd/mm/yyyy') AND A.fecnom <= to_date('$fecreg2','dd/mm/yyyy') and
                                a.codcon=e.codcon   and ( montorethist('$codtipapodes','A',A.CODNOM,B.CODEMP,A.CODCAR,'$fecreg1','$fecreg2') +  montorethist('$codtipapodes','R',A.CODNOM,B.CODEMP,A.CODCAR,'$fecreg1','$fecreg2') )> 0
        						GROUP BY A.CODEMP, B.CEDEMP, A.CODNOM, A.CODCAR, to_char(coalesce(FECREI,FECING),'dd/mm/yyyy') ,
        	                    B.NOMEMP , B.NACEMP, to_char(B.FECNAC,'dd/mm/yyyy') , B.SEXEMP ,B.CODNIV, a.codcat order by cast(REPLACE(b.cedemp,'.', '') as int ) ";
        
        return $this->select($sql);
    }
	
    function CFnomnom($tipnom)
    {
        $sql = "SELECT DISTINCT(NOMNOM) as nombre
            									FROM NPNOMINA WHERE CODNOM = '$tipnom'";
        return $this->select($sql);
    }
	
    function sql4($tbcodtipapo, $especial, $tb2codemp, $fecreg1, $fecreg2)
    {
        if ($especial == 'S')
        {
            $especial = " a.especial = 'S' AND
            		A.CODNOMESP = '$tipnomesp' AND
             ";
            $especial2 = " a.especial = 'S' AND
            		A.CODNOMESP = '$tipnomesp' AND
             ";
        }
        else
        {
            if ($especial == 'N')
            {
                $especial = " a.especial = 'N' AND --A.CODCON<>'A03' AND";
        
            }
            else
            if ($especial == 'T')
                $especial = "A.CODCON<>'A03' AND";
        }
        $sql = "SELECT SUM(monto) as ELMONTO FROM nphiscon A, NPHOJINT B, NPCONTIPAPORET C
                    										 WHERE
                    										 C.CODTIPAPO='$tbcodtipapo' AND
                    										 A.CODNOM=C.CODNOM AND
                    										 A.CODCON=C.CODCON AND
                    										 C.TIPO='R' AND
                    										 B.CODEMP=A.CODEMP and ".$especial2."
                    										 B.CODEMP='$tb2codemp' and
                    								         a.FECNOM>=to_date('$fecreg1','dd/mm/yyyy') AND
                    								         a.FECNOM<=to_date('$fecreg2','dd/mm/yyyy')";
        return $this->select($sql);
    }
    
    function sql5($tbcodtipapo, $tb2codemp, $fecreg1, $fecreg2, $tb2codcar)
    {
    
        $sql = "SELECT SUM(MONTO) as  ELMONTO
                    										 FROM NPCONTIPAPORET C, NPHOJINT B, NPHISCON A
                    										 WHERE
                    										 C.CODTIPAPO='$tbcodtipapo' AND
                    										 B.CODEMP='$tb2codemp' AND
                    										 FECNOM>=to_date('$fecreg1','dd/mm/yyyy') AND
                    								  		 FECNOM<=to_date('$fecreg2','dd/mm/yyyy') AND
                    										 A.CODCAR='$tb2codcar' AND
                    										 A.CODNOM=C.CODNOM AND
                    										 A.CODCON=C.CODCON AND
                    										 C.TIPO='A' AND
                    										 B.CODEMP=A.CODEMP";
        
        return $this->select($sql);
    }
}




?>
