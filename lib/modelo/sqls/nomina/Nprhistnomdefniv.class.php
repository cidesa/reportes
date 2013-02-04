<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprhistnomdefniv extends baseClases
{

    function sql($especial,$tipnomesp,$emphas,$empdes,$nivdes,$nivhas,$cardes,$carhas,$condes,$conhas,$tipnomdes,$fechades,$fechahas)
    {
        if ($especial == 'S')
        {
            $especial = " G.especial = 'S' AND
                        G.CODNOMESP = '$tipnomesp' and  ";
        }
        else
        {
            if ($especial == 'N')
                $especial = " G.especial = 'N' AND";
        }
        
        $sql = "SELECT DISTINCT(C.CODEMP) as codemp, to_char(C.FECRET,'dd/mm/yyyy') as fecret,
        				C.NOMEMP as nomemp,	G.CODCAR, d.codcat as codcta,	d.nomcat as nomcat,
        				to_char(C.FECING,'dd/mm/yyyy') as fecing,
        				C.NUMCUE as CUENTA_BANCO,G.CODNIV as codniv, C.CEDEMP as cedemp,
        				f.nomban as nomban,	G.CODCAR as CODCAR, cast(G.CODCAR as int ) as codcarord,I.NOMCAR as nomcar,
        				E.DESNIV as desniv,
        				(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
        				G.CODCON as codcon,	LTRIM(RTRIM(H.NOMCON)) AS NOMCON,
        				(CASE WHEN H.OPECON='A' THEN coalesce(sum(G.MONTO),0) ELSE 0 END) as ASIGNA,
        				(CASE WHEN H.OPECON='D' THEN coalesce(sum(G.MONTO),0) ELSE 0 END) as DEDUC, cast(REPLACE(c.cedemp,'.', '') as int )
        				FROM
        				NPHOJINT C LEFT OUTER JOIN npbancos f ON (C.CODBAN=f.codban),
        				NPCATPRE D,	NPESTORG E,	nphiscon G,	NPDEFCPT H, NPCARGOS I
        				WHERE
        					C.CODEMP <= '$emphas' AND
        									C.CODEMP >= '$empdes' AND
        									G.CODNIV >= '$nivdes' AND
        									G.CODNIV <= '$nivhas' AND
        									G.CODCAR >= '$cardes' AND
        								    G.CODCAR <= '$carhas' AND
        									G.CODCON >= '$condes' AND
        									G.CODCON <= '$conhas' AND  ".$especial."
        			
        				G.CODEMP=C.CODEMP AND
        				G.CODCON=H.CODCON AND
        				D.CODCAT=G.CODCAT AND
        				E.CODNIV=G.CODNIV AND
        				G.CODNOM = '$tipnomdes' AND
        				G.CODCAR=I.CODCAR AND
        				--B.STATUS='V' AND
        				H.IMPCPT='S' and
        				  g.fecnomdes>=to_date('$fechades','dd/mm/yyyy') and
        					                g.fecnom<=to_date('$fechahas','dd/mm/yyyy')
        				GROUP BY
        				C.CODEMP, C.FECRET,
        				C.NOMEMP ,	G.CODCAR, d.codcat ,	d.nomcat ,
        				C.FECING,
        				C.NUMCUE ,G.CODNIV , C.CEDEMP ,
        				f.nomban ,	G.CODCAR , cast(G.CODCAR as int ) ,I.NOMCAR ,
        				E.DESNIV ,
        				C.STAEMP,
        				G.CODCON ,H.NOMCON,
        				H.OPECON
        				ORDER BY G.CODNIV,codcta, codcarord, cast(REPLACE(c.cedemp,'.', '') as int )";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	
    function sqls($var, $tipnom)
    {
        if ($var == 1)
        {
            $sql = "select upper(nomnom) as nombre from NPASICAREMP where codnom='$tipnom'";
        } else if ($var == 2)
        {
            $sql = "SELECT to_char(ULTFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
        } else
            $sql = "SELECT to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnom'";
        //print"<pre> $sql=".$sql;
        return $this->select($sql);
    }
	
    function sueldosr($tbcodcar)
    {
        $sql = "select suecar as valor from npcargos where codcar ='$tbcodcar'";
        return $this->select($sql);
    }
	
    function shh($tbcodcar,$tbcodemp,$tbcodcon)
    {
        $sql = "SELECT coalesce(ACUMULADO,0) as SALDO FROM NPASICONEMP
				 WHERE CODCAR = '$tbcodcar' AND CODEMP='$tbcodemp' AND CODCON='$tbcodcon'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
	
    function p($tbcodcon)
    {
        $sql = "SELECT CODTIPPRE as VALOR FROM NPTIPPRE WHERE CODCON='$tbcodcon'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>
