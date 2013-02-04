<?php

require_once("../../lib/modelo/baseClases.class.php");

class Oce2106 extends baseClases {

    function SQLp($cardes,$carhas) {

				$sql="select a.codcar,a.nomcar,coalesce(b.canmuj,0) as canmuj,coalesce(b.canhom,0) as canhom,
					coalesce(0,0) as canmujt,coalesce(0,0) as canhomt,
					coalesce(b.canpre-b.canasi,0) as canvac,
					coalesce(0,0) as canvact,
					coalesce(b.canpre,0) as canpre,
					coalesce(0,0) as canpret,
					formatonum(coalesce(a.suecar,0)) as suecar,
					formatonum(coalesce(0,0)) as suecart,
					formatonum(coalesce(0,0)) as suecarta
					from forcargos a, npcarpre b
					where
					b.codcar>=('$cardes') and
					b.codcar<=('$carhas') and
					a.codcar=b.codcar
					order by a.codcar
					";
//sprint "<pre>".$sql;exit;
		return $this->select($sql);
    }
    function sqlano()
    {
    	$sql="select to_char(fecper,'yyyy') as ano from fordefniv";

    	return $this->select($sql);
    }
    function sqlsector($sector)
    {
    	$sql="select nomcat from fordefcatpre where trim(codcat)=trim('$sector')";
		$arrp=$this->select($sql);
    	return $arrp[0]["nomcat"];
    }
    function SQLprog($prog)
    {
    	$sql="select nomcat  from fordefcatpre where trim(codcat)=trim('$prog')";
		$arrp=$this->select($sql);
    	return $arrp[0]["nomcat"];
    }
    function SQLact($act)
    {
    	$sql="select nomcat  from fordefcatpre where trim(codcat)=trim('$act')";
		$arrp=$this->select($sql);
    	return $arrp[0]["nomcat"];
    }
    function sqlunij($unij)
    {
    	$sql="select a.nomuni  as nomuni from fordefunieje a, fordefcatpre b where a.coduni=b.coduni and b.codcat like '$unij%'";
		$arrp=$this->select($sql);
    	return $arrp[0]["nomuni"];
    }

}
?>