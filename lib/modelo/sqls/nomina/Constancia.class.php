<?php
require_once("../../lib/modelo/baseClases.class.php");
class Constancia extends BaseClases {

	public function sqlp($cedemp)
    {
		$sql= "select
			   a.codemp,
			   a.nomemp as nombre,
			   coalesce(a.nacemp,'V') as nacionalidad,
			   a.cedemp as cedula,
			   to_char(a.fecing,'dd/mm/yyyy') as fecha,
			   to_char(a.fecret,'dd/mm/yyyy') as retiro,
			   case when a.staemp='R' then 'presto' when a.staemp='S' then 'presto' else 'presta' end  as estatus,
			   b.codcar as codcargo,
			   trim(b.nomcar) as cargo,
			   b.nomcat as categoria,
			   c.suecar as sueldo
			   from
			   nphojint a
			   left outer join
			   npasicaremp b
			   on (a.codemp=b.codemp)
			   left outer join
			   npcargos c
			   on (b.codcar=c.codcar)
			   where
			   trim(a.cedemp) = trim('".$cedemp."')
			   group by b.codcar,b.nomcar,a.codemp,a.cedemp,nacionalidad,a.nomemp,a.fecing,a.fecret,a.staemp,b.nomcat,c.suecar";
		//print $sql;exit;
	    return $this->select($sql);

    }

	public function suecont($codemp,$codcar)
    {
		$sql= "select monto, nomcon
			   from nphiscon
			  where trim(codemp)=trim('".$codemp."') and
			  upper(nomcon) like upper('%remuneracion%') and
			  trim(codcar)=trim('".$codcar."') and
			  fecnom = (select max(fecnom) from nphiscon where trim(codemp)=trim('".$codemp."') and trim(codcar)=trim('".$codcar."'))";
		//print $sql;exit;
	    return $this->select($sql);

    }

	public function asigjubpen($codemp)
    {
		$sql= "select monto, nomcon
			  from nphiscon
			  where
			  trim(codemp)=trim('".$codemp."') and
			  codnom='140' and
			  fecnom = (select max(fecnom) from nphiscon where trim(codemp)=trim('".$codemp."') and codnom='140')";
		//print $sql;exit;
	    return $this->select($sql);

    }
}
?>