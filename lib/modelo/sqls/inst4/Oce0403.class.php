<?php
require_once("../../lib/modelo/baseClases.class.php");

class Oce0403 extends baseClases {

  function sqlp($coddes,$codhas)
  {
	$sql="select distinct substr(a.codpre,1,5) as accesp,
				(select nompre from cpdeftit where trim(codpre)=substr(trim(a.codpre),1,5)) as nompre,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%401%'),0) as mon401,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%402%'),0) as mon402,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%403%'),0) as mon403,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%404%'),0) as mon404,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%405%'),0) as mon405,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%407%'),0) as mon407,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%408%'),0) as mon408,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%411%'),0) as mon411
				from
				cpdeftit a
				where length(trim(codpre))<=3 and
				substr(a.codpre,1,5)>='$coddes' and
				substr(a.codpre,1,5)<='$codhas'
				";
	 $rs = $this->select($sql);

	 $sql1="select distinct substr(a.codpre,1,5) as accesp,
				(select nompre from cpdeftit where trim(codpre)=substr(trim(a.codpre),1,5)) as nompre,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%401%'),0) as mon401,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%402%'),0) as mon402,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%403%'),0) as mon403,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%404%'),0) as mon404,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%405%'),0) as mon405,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%407%'),0) as mon407,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%408%'),0) as mon408,
				coalesce((select sum(monasi) from cpasiini where perpre='00' and codpre like trim(substr(a.codpre,1,5))||'%411%'),0) as mon411
				from
				cpdeftit a
				where length(trim(codpre))=5 and
				substr(a.codpre,1,5)>='$coddes' and
				substr(a.codpre,1,5)<='$codhas'
				";

	// H::PrintR($sql1);exit;
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