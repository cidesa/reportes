<?php
require_once ("../../lib/modelo/baseClases.class.php");
class Nprnomina extends baseClases
{

    function sql($cod1, $cod2)
    {
        $sql = "select distinct a.codnom, a.nomnom, a.frecal, to_char(a.ultfec,'dd/mm/yyyy') as ultfec,
					 to_char(a.profec,'dd/mm/yyyy') as profec, a.numsem, a.ordpag, a.tipcau, a.refcau, a.tipprc,
			         a.refprc, a.tipcom, a.refcom,count(codemp) as canemp
					 from npnomina a left outer join npasicaremp b on (a.codnom = b.codnom)
					 where a.codnom>='$cod1' and a.codnom<='$cod2'
					 group by  a.codnom, a.nomnom, a.frecal, to_char(a.ultfec,'dd/mm/yyyy'),
					 to_char(a.profec,'dd/mm/yyyy'), a.numsem, a.ordpag, a.tipcau, a.refcau, a.tipprc,
			         a.refprc, a.tipcom, a.refcom ";
        return $this->select($sql);
    }

    function sqlx($tbcodnom)
    {
        $sql = "SELECT COUNT(DISTINCT(a.CODEMP)) as numero FROM NPNOMCAL a,  NPHOJINT C WHERE a.CODNOM='$tbcodnom' and a.codemp=c.codemp and c.staemp='A' and a.especial='N'";
		
		return $this->select($sql);
    }
}

?>
