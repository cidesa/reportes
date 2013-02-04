<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Nprnomdefniv extends BaseClases
{

    function SQLp($especial, $emphas, $empdes, $nivdes, $nivhas, $cardes, $carhas, $condes, $conhas, $tipnomdes, $tipnomesp)
    {
        if ($especial == 'S')
        {
            $sql = "SELECT DISTINCT(C.CODEMP) as codemp, to_char(C.FECRET,'dd/mm/yyyy') as fecret,
						C.NOMEMP as nomemp,	B.CODCAR, d.codcat as codcta,	d.nomcat as nomcat,
						to_char(C.FECING,'dd/mm/yyyy') as fecing,
						C.NUMCUE as CUENTA_BANCO,C.CODNIV as codniv, C.CEDEMP as cedemp,
						f.nomban as nomban,	B.CODCAR as CODCAR, cast(B.CODCAR as int ) as codcarord,B.NOMCAR as nomcar,
						E.DESNIV as desniv,
						(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
						G.CODCON as codcon,	H.NOMCON AS NOMCON,
						(CASE WHEN G.ASIDED='A' THEN coalesce(G.SALDO,0) ELSE 0 END) as ASIGNA,
						(CASE WHEN G.ASIDED='D' THEN coalesce(G.SALDO,0) ELSE 0 END) as DEDUC
						FROM
						NPHOJINT C LEFT OUTER JOIN npbancos f ON (C.CODBAN=f.codban),
						NPASICAREMP B,	NPCATPRE D,	NPESTORG E,	NPNOMCAL G,	NPDEFCPT H
						WHERE
							C.CODEMP <= '$emphas' AND
							C.CODEMP >= '$empdes' AND
							C.CODNIV >= '$nivdes' AND
							C.CODNIV <= '$nivhas' AND
							B.CODCAR >= '$cardes' AND
						       B.CODCAR <= '$carhas' AND
							G.CODCON >= '$condes' AND
							G.CODCON <= '$conhas' AND
							G.especial='$especial' AND
							B.CODEMP=C.CODEMP AND
							G.CODEMP=C.CODEMP AND
							G.CODCON=H.CODCON AND
						       D.CODCAT=B.CODCAT AND
						       E.CODNIV=C.CODNIV AND
						       B.CODNOM = '$tipnomdes' AND
							G.CODNOM = '$tipnomdes' AND
							G.CODNOMESP = '$tipnomesp' AND
							B.STATUS='V' AND
							H.IMPCPT='S'
						ORDER BY C.CODNIV,codcta, codcarord, C.CODEMP";
            //print"<pre> S= ".$sql;exit;
        }
        else
        {
            $sql = "SELECT DISTINCT(C.CODEMP) as codemp, to_char(C.FECRET,'dd/mm/yyyy') as fecret,
						C.NOMEMP as nomemp,	B.CODCAR, d.codcat as codcta,	d.nomcat as nomcat,
						to_char(C.FECING,'dd/mm/yyyy') as fecing,
						C.NUMCUE as CUENTA_BANCO,C.CODNIV as codniv, C.CEDEMP as cedemp,
						f.nomban as nomban,	B.CODCAR as CODCAR, cast(B.CODCAR as int ) as codcarord,B.NOMCAR as nomcar,
						E.DESNIV as desniv,
						(CASE WHEN C.STAEMP='A' THEN 'ACTIVO' WHEN C.STAEMP='S' THEN 'SUSPENDIDO' WHEN C.STAEMP='V' THEN 'VACACIONES' ELSE '' END) as ESTATUS,
						G.CODCON as codcon,	H.NOMCON AS NOMCON,
						(CASE WHEN G.ASIDED='A' THEN coalesce(G.SALDO,0) ELSE 0 END) as ASIGNA,
						(CASE WHEN G.ASIDED='D' THEN coalesce(G.SALDO,0) ELSE 0 END) as DEDUC
						FROM
						NPHOJINT C LEFT OUTER JOIN npbancos f ON (C.CODBAN=f.codban),
						NPASICAREMP B,	NPCATPRE D,	NPESTORG E,	NPNOMCAL G,	NPDEFCPT H
						WHERE
							C.CODEMP <= '$emphas' AND
							C.CODEMP >= '$empdes' AND
							C.CODNIV >= '$nivdes' AND
							C.CODNIV <= '$nivhas' AND
							B.CODCAR >= '$cardes' AND
						       B.CODCAR <= '$carhas' AND
							G.CODCON >= '$condes' AND
							G.CODCON <= '$conhas' AND
							G.especial='$especial' AND
							B.CODEMP=C.CODEMP AND
							G.CODEMP=C.CODEMP AND
							G.CODCON=H.CODCON AND
						       D.CODCAT=B.CODCAT AND
						       E.CODNIV=C.CODNIV AND
						       B.CODNOM = '$tipnomdes' AND
							G.CODNOM = '$tipnomdes' AND
							B.STATUS='V' AND
							H.IMPCPT='S'
						ORDER BY C.CODNIV,codcta, codcarord, C.CODEMP";
            //print"<pre> N= ".$sql;exit;
        }
        return $this->select($sql);
    }
    function rs($tipnomdes)
    {
        $sql = "select upper(nomnom) as nombre from NPNOMINA where codnom='$tipnomdes'";
        return $this->select($sql);
    }

    function sr($tipnomdes)
    {
        $sql = "SELECT frecal, numsem, to_char(ULTFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnomdes'";
        return $this->select($sql);
    }

    function ss($tipnomdes)
    {
        $sql = "SELECT frecal, numsem, to_char(PROFEC,'dd/mm/yyyy') as FECHA FROM NPNOMINA  WHERE CODNOM='$tipnomdes'";
        return $this->select($sql);
    }
    function sql2($tbcodcar)
    {
        $sql = "select suecar as valor from npcargos where codcar ='$tbcodcar'";
        return $this->select($sql);
    }
	function shh($tbcodcar,$tbcodemp,$tbcodcon)
    {
        $sql = "SELECT coalesce(ACUMULADO,0) as SALDO FROM NPASICONEMP
				 WHERE CODCAR = '$tbcodcar' AND CODEMP='$tbcodemp' AND CODCON='$tbcodcon'";
        return $this->select($sql);
    }
	function p($tbcodcon)
    {
        $sql = "SELECT CODTIPPRE as VALOR FROM NPTIPPRE WHERE CODCON='$tbcodcon'";
        return $this->select($sql);
    }
}
?>
