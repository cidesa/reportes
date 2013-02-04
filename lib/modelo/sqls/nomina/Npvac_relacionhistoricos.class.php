<?php
require_once ("../../lib/modelo/baseClases.class.php");

class Npvac_relacionhistoricos extends baseClases
{

    function sql($tipnomdes, $codempdes, $codemphas, $codnivdes, $codnivhas)
    {
        $sql = "SELECT
    						DISTINCT
    							C.CODNIV,
    							D.DESNIV
    						FROM  
    							NPCATPRE E,NPVACREGSAL A,NPHOJINT C, NPASICAREMP B, NPESTORG D
    						WHERE
    							B.CODNOM = '$tipnomdes' AND
    							B.CODNOM = A.CODNOM AND
    							B.CODCAT = E.CODCAT AND
    							B.CODCAR = A.CODCAR AND
    							B.CODEMP = C.CODEMP AND
    							B.CODEMP = A.CODEMP AND
    							C.CODNIV = D.CODNIV AND
    							B.CODEMP >= '$codempdes' AND
    							B.CODEMP <= '$codemphas' AND 
    							C.CODNIV >= '$codnivdes' AND
    							C.CODNIV <= '$codnivhas' AND 
    							B.STATUS='V' AND
    							A.STAVAC='S'
    						ORDER BY
    							C.CODNIV";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function sqlc($tipnomdes)
    {
        $sql = "SELECT codnom, nomnom FROM npnomina WHERE codnom='$tipnomdes'";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function sqla($tipnomdes, $codempdes, $codemphas, $tbcodniv)
    {
        $sql = "SELECT
    						 DISTINCT
    							C.CODEMP,         
    							C.NOMEMP,
    							C.FECING,
    							C.FECRET,
    							C.CEDEMP,
    							A.CODCAR,         
    							B.NOMCAR,
    							B.CODCAT,
    							E.NOMCAT,
    							C.CODNIV,
    							D.DESNIV
    						FROM  
    							NPCATPRE E,NPVACREGSAL A,NPHOJINT C, NPASICAREMP B, NPESTORG D
    						WHERE
    							B.CODNOM = '$tipnomdes' AND
    							B.CODNOM = A.CODNOM AND
    							B.CODCAT = E.CODCAT AND
    							B.CODCAR = A.CODCAR AND
    							B.CODEMP = C.CODEMP AND
    							B.CODEMP = A.CODEMP AND
    							C.CODNIV = D.CODNIV AND
    							B.CODEMP >= '$codempdes' AND
    							B.CODEMP <= '$codemphas' AND 
    							C.CODNIV = '$tbcodniv' AND
    							B.STATUS='V' AND
    							A.STAVAC='S'
    							ORDER BY
    							C.CODEMP";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
    function sqlb($tipnomdes, $tb2codemp)
    {
        $sql = "SELECT
    									to_char(FECHASALIDA,'dd/mm/yy') as fechasalida,
    									to_char(FECHAENTRADA,'dd/mm/yy') as fechaentrada,
    									PERINI,
    									PERFIN,
    									DIASBONO
    								FROM
    									NPNOMINA H, 
    									NPCATPRE E,
    									NPVACREGSAL A,
    									NPHOJINT C, 
    									NPASICAREMP B, 
    									NPESTORG D
    								WHERE
    									B.CODNOM = '$tipnomdes' AND
    									B.CODNOM=A.CODNOM AND
    									B.CODNOM=H.CODNOM AND
    									B.CODCAT=E.CODCAT AND
    									B.CODCAR=A.CODCAR AND
    									B.CODEMP=C.CODEMP AND
    									B.CODEMP=A.CODEMP AND
    									C.CODNIV=D.CODNIV AND
    									B.CODEMP = '$tb2codemp' AND
    									B.STATUS='V' AND
    									A.STAVAC='S'
    								ORDER BY
    									C.CODEMP ASC,
    									PERINI";
        //print"<pre> sql=".$sql;exit;
        return $this->select($sql);
    }
}
?>
