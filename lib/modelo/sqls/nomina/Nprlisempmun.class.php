<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprlisempmun extends baseClases {

  function sqlp($ceddes,$cedhas,$codnivdes,$codnivhas,$codciudes,$codciuhas,$nomina)
  {
	$sql="select  c.codnom,e.nomnom,a.cedemp,a.nomemp,min(d.nomcar),f.desniv,b.nomciu from nphojint a
		left outer join npciudad b on (a.codciu=b.codciu)
		left outer join npestorg f on (a.codniv=f.codniv) ,npnomina e, npasicaremp c
		left outer join npcargos d on (c.codcar=d.codcar)
		where
		rtrim(c.codnom)=rtrim('$nomina')
		and rtrim(a.cedemp)>=rtrim('$ceddes')
		and rtrim(a.cedemp)<=rtrim('$cedhas')
		and rtrim(a.codniv)>=rtrim('$codnivdes')
		and rtrim(a.codniv)<=rtrim('$codnivhas')
		and rtrim(a.codciu)>=rtrim('$codciudes')
		and rtrim(a.codciu)<=rtrim('$codciuhas')
		and a.codemp=c.codemp
		and c.codnom=e.codnom
		group by c.codnom,e.nomnom,a.cedemp,a.nomemp,f.desniv,b.nomciu
		order by c.codnom
";
//print $sql;exit;
   return $this->select($sql);
  }

  function sqlnomina($nomina)
  {
  	$sql="SELECT (nomnom) as nomnom FROM NPNOMINA where codnom='$nomina'";

	$aux = $this->select($sql);
  	return $aux[0]["nomnom"];
  }
}
?>