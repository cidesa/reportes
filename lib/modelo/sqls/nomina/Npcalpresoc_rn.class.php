<?php
	require_once("../../lib/modelo/baseClases.class.php");
	
class Npcalpresoc_rn extends baseClases{
	
	
		function sqlp($codempdes,$codemphas){
		$sql="select a.*,to_char(a.feccor,'dd/mm/yyyy') as feccor,c.nomemp,to_char(b.feccal,'dd/mm/yyyy') as fecing
					from NPPRESOC a, NPasiempcont b ,NPHOJINT c
					where
					a.codemp=c.codemp and
					a.codemp >= '$codempdes' and
					a.codemp <= '$codemphas' and
					a.codemp=b.codemp";
		//				print("<pre>".'....!!! $sql='.$sql);exit;
		
		return $this->select($sql);		
		
	}
	
	function sqlx($codempdes,$codemphas){
		$sql="select a.*,to_char(a.feccor,'dd/mm/yyyy') as feccor,c.nomemp,to_char(b.feccal,'dd/mm/yyyy') as fecing
					from NPPRESOC a, NPasiempcont b ,NPHOJINT c
					where
					a.codemp=c.codemp and
					a.codemp>='$codempdes' and
					a.codemp<='$codemphas' and
					a.codemp=b.codemp";
		//print("<pre>".'....!!! $sql='.$sql);exit;
		return $this->select($sql);
		
	}
	
	function sql2($codemp){
		
		$sql="Select *,to_char(fecfin,'dd/mm/yyyy') as fecfin, fecfin as fec2
							from npimppresoc
							where codemp='$codemp' and tipo<>'A' and tipo<>'P' order by fec2";
		
		
		return $this->select($sql);
		
	}
	
	function sqlantiguedad($codemp){
		$sql="Select max(antacum) as antiguedad from npimppresoc where codemp='$codemp' and tipo<>'A' and tipo<>'P' and fecfin=(Select max(fecfin) as antiguedad from npimppresoc where codemp='$codemp' and tipo<>'A' and tipo<>'P' and fecini<feccor)";
		
		return $this->select($sql);
	}
	
	function sqldiaadi($codemp){
		$sql="select coalesce(sum(diaart108),0) as diaadi from npimppresoc where codemp='$codemp' and (tipo='A' or tipo='P')";
		
		return $this->select($sql);
		
	}
	
	function sqlfecfin($codemp){
		$sql="Select *,to_char(fecfin,'dd/mm/yyyy') as fecfin, fecfin as fec2
							from npimppresoc
							where
							codemp='$codemp' and
							diadif<=0 and salempdia>0 and (valart108>0 or adeant>0)
							order by fec2";
		
		return $this->select($sql);
		
	}
	
	function valart108A($codemp){
		$sql="Select valart108 from npimppresoc where codemp='$codemp'
				       and tipo='A'";
		
		return $this->select($sql);
		
	}
	
	function valart108P($codemp){
		$sql="Select valart108 from npimppresoc where codemp='$codemp'
				       and tipo='P'";
		
		return $this->select($sql);
		
	}
	
	
}

?>