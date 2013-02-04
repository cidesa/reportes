<?php
require_once("../../lib/modelo/baseClases.class.php");

class Bm2 extends baseClases
{

    function SQLp($ubides,$ubihas)
    {
    	$sql="select
    		  a.codubi as codubi,
    		  c.desubi,
    		  trim(a.codact),
    		  trim(a.codmue),
    		  trim(generar_descripcion(a.codmue)),
    		  to_char(a.fecreg,'dd/mm/yyyy'),
    		  formatonum(a.valini) as valest
    		  from
    		  bnregmue a
    		  left outer join bndefact b on(a.codact=b.codact),
    		  bnubibie c
    		  where
    		  rpad(a.codubi,30,' ')>=rpad('".$ubides."',30,' ') and
    		  rpad(a.codubi,30,' ')<=rpad('".$ubihas."',30,' ') and
    		  a.codubi=c.codubi
    		  order by a.codubi, a. codact, a.codmue";

    	return $this->select($sql);
    }
 }
?>