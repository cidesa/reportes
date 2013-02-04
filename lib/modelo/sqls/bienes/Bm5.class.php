<?php
require_once("../../lib/modelo/baseClases.class.php");

class Bm5 extends baseClases
{
    function SQLp($ubides,$ubihas,$mes,$ano)
    {
    	$sql="select a.codubi as codubi, a.nomubi as nomubi,
    		 sum(a.movant) as anterior,sum(a.movinc) as incorporacion,sum(a.movdes) as desincorporacion,sum(a.movfal) as faltante from (
    		 select a.codubiori as codubi, c.desubi as nomubi,
    		 coalesce(sum(case when b.desinc='N' then a.mondismue else ((-1)*a.mondismue) end),0) as movant,0 as movinc,0 as movdes,0 as movfal
			 from bndismue a left outer join bnubibie c on (a.codubiori=c.codubi), bndisbie b
			 where substr(a.tipdismue,1,6)=b.coddis and
			 a.codubiori>=rpad('".$ubides."',30,' ') and a.codubiori<=rpad('".$ubihas."',30,' ') and
			 --to_char(a.fecdismue,'mm')<'".$mes."' and
			 to_char(a.fecdismue,'yyyy')='".$ano."'
			 group by a.codubiori, c.desubi
    		 union

    		 select a.codubiori as codubi, c.desubi as nomubi,
    		 0 as movant,coalesce(sum(a.mondismue),0) as movinc,0 as movdes,0 as movfal
    		 from bndismue a left outer join bnubibie c on (a.codubiori=c.codubi), bndisbie b
    		 where substr(a.tipdismue,1,6)=b.coddis and b.desinc='N' and
    		 a.codubiori>=rpad('".$ubides."',30,' ') and a.codubiori<=rpad('".$ubihas."',30,' ') and
    		 --to_char(a.fecdismue,'mm')='".$mes."' and
    		 to_char(a.fecdismue,'yyyy')='".$ano."'
    		 group by a.codubiori, c.desubi
    		 union

    		 select a.codubiori as codubi, c.desubi as nomubi,
    		 0 as movant,0 as movinc,coalesce(sum(a.mondismue),0) as movdes,0 as movfal
    		 from bndismue a left outer join bnubibie c on (a.codubiori=c.codubi), bndisbie b
    		 where substr(a.tipdismue,1,6)=b.coddis and b.desinc='S' and
    		 upper(b.desdis) not like upper('faltantes por investigar') and
    		 a.codubiori>=rpad('".$ubides."',30,' ') and a.codubiori<=rpad('".$ubihas."',30,' ') and
    		 --to_char(a.fecdismue,'mm')='".$mes."' and
    		 to_char(a.fecdismue,'yyyy')='".$ano."'
    		 group by a.codubiori, c.desubi
	   		 union

    		 select a.codubiori as codubi, c.desubi as nomubi,
    		 0 as movant,0 as movinc,0 as movdes,coalesce(sum(a.mondismue),0) as movfal
    		 from bndismue a left outer join bnubibie c on (a.codubiori=c.codubi), bndisbie b
    		 where substr(a.tipdismue,1,6)=b.coddis and b.desinc='S' and
    		 upper(b.desdis) like upper('faltantes por investigar') and
    		 a.codubiori>=rpad('".$ubides."',30,' ') and a.codubiori<=rpad('".$ubihas."',30,' ') and
    		 --to_char(a.fecdismue,'mm')='".$mes."' and
    		 to_char(a.fecdismue,'yyyy')='".$ano."'
    		 group by a.codubiori, c.desubi
    		 ) as a group by a.codubi, a.nomubi order by a.codubi";

    	return $this->select($sql);
    }
 }
?>