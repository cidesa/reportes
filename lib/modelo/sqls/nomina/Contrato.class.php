<?php
require_once("../../lib/modelo/baseClases.class.php");
class Contrato extends BaseClases {

	public function sqlp($cedemp)
    {
		$sql= "select
			   a.nomemp as nombre,
			   coalesce(a.nacemp,'V') as nacionalidad,
			   a.cedemp as cedula,
			   to_char(a.fecing,'dd/mm/yyyy') as fecha,
			   a.sexemp as sexo,
			   a.edociv as estado,
			   b.nomcar as cargo,
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
			   trim(a.cedemp) = trim('".$cedemp."')";
#		print $sql;exit;
	    return $this->select($sql);

    }
}
?>