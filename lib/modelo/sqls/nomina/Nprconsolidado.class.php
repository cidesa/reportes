<?php


class Nprconsolidado extends baseClases
{
    function sqlp($nom)
    {
        $sql = "select a.nacemp,a.cedemp as codemp ,a.codemp as idemp,b.codnom, a.nomemp,numcue,d.codban as codban,
						b.codcar,c.nomcar,sum(montonomina) as monto 
						from nphojint a,npasicaremp b,npcargos c ,npbancos d
						where 
						a.codban=d.codban and
						b.codemp = a.codemp and 
						b.codcar=c.codcar and
						d.codban='$nom' and
						status='V' 
						and a.staemp in (select codsitemp from npsitemp where calnom='S')
						and b.codemp in (select distinct codemp from npnomcal)
						 --where codnom=:tipnomdes)
						and numcue is not null
						group by b.codnom,d.codban,a.cedemp,a.codemp,a.nomemp,b.codcar,c.nomcar,numcue,a.nacemp
						order by b.codnom,d.codban, a.codemp";
        return $this->select($sql);
    }
	
	function sqly($nom)
    {
        $sql = "select nomban from npbancos where codban='$nom'";		
        return $this->select($sql);
    }
	
	function sqlx($codnom)
    {
        $sql = "select codnom, nomnom, to_char(ultfec,'dd/mm/yyyy') as ultfec, to_char(profec,'dd/mm/yyyy') as profec 
			from npnomina where codnom='$codnom'";
        return $this->select($sql);
    }
	
	function sqlx2($codnom)
    {
        $sql = "select codnom, nomnom, ultfec, profec from npnomina where codnom='$codnom'";
        return $this->select($sql);
    }
}
?>
