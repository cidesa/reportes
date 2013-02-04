<?php
require_once("../../lib/modelo/baseClases.class.php");

class Oce1922 extends baseClases {

  function sqlp($coddes,$codhas)
  {
	$sql="select distinct substr(a.codpre,1,5) as accesp,
				(select nompre from cpdeftit where codpre=rpad(substr(a.codpre,1,5),50,' ')) as nompre,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%401%'),0)) as mon401,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%402%'),0)) as mon402,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%403%'),0)) as mon403,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%404%'),0)) as mon404,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%405%'),0)) as mon405,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%407%'),0)) as mon407,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%408%'),0)) as mon408,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%411%'),0)) as mon411
				from 
				cpdeftit a
				where length(trim(codpre))<=5 and
				substr(a.codpre,1,5)>='$coddes' and
				substr(a.codpre,1,5)<='$codhas'
				";
	 $rs = $this->select($sql); 
	 
	 $sql1="select distinct substr(a.codpre,1,5) as accesp,
				(select nompre from cpdeftit where codpre=rpad(substr(a.codpre,1,5),50,' ')) as nompre,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%401%'),0)) as mon401,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%402%'),0)) as mon402,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%403%'),0)) as mon403,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%404%'),0)) as mon404,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%405%'),0)) as mon405,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%407%'),0)) as mon407,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%408%'),0)) as mon408,
				formatonum(coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%411%'),0)) as mon411
				from 
				cpdeftit a
				where length(trim(codpre))<=5 and
				substr(a.codpre,1,5)>='$coddes' and
				substr(a.codpre,1,5)<='$codhas'
				";
	 $rs1 = $this->select($sql1);
	 
   return  array('0' => $rs,'1' =>$rs1 );
  }
  
  function sqlanofis()
  {
  	 $sql="select to_char(fecini,'yyyy') as anofis from contaba";
	 
	 $rs = $this->select($sql);
	 return $rs[0]['anofis'];
  }

}
?>