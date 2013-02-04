<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcactecon extends baseClases
{
	function sqlp($coddes,$codhas,$codanodes,$codanohas)
	{

		$sql=  "SELECT distinct ANOACT AS CODANO

        FROM FCACTCOM

        where
          codact>= '".$coddes."' and
          codact<= '".$codhas."' and
          ANOACT >= '".$codanodes."' and
          ANOACT <= '".$codanohas."'

        order by codano"; //H::PrintR($sql); exit;
		return $this->select($sql);
	}


	function sqlp1($codigo)
	{

		$sql= " select a.codact as codigo, a.desact as descripcion,
        case when a.minofac='F' then 'U/Bs.' when a.minofac='M' then '%' end as alicuota,
        case when a.exoner='S' then 'SI' WHEN a.exoner='N' then 'NO' end as exo,
        case when a.exento='S' then 'SI' WHEN a.exento='N' then 'NO' end as exento,
        a.rebaja AS rebaja, a.porreb as monrebaja

        FROM FCACTCOM A

        where
        a.ANOACT = '".$codigo."'
        order by a.codact";
		return $this->select($sql);
	}


}
?>
