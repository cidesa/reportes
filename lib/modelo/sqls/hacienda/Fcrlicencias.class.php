<?php
require_once("../../lib/modelo/baseClases.class.php");

class Fcrlicencias extends baseClases
{
	function sqlp($rifcondes,$rifconhas,$caj1,$caj2,$fechadesde,$fechahasta,$direccion,$statusl)
	{

	$fecha=date("d/m/Y");
	if ($statusl=='T'){
			$this->sql="select a.numlic,a.rifcon, a.catcon, a.nomneg,a.dirpri,b.destiplic
									from fcsollic a,fctiplic b
									where
									a.numlic >= '".str_pad($rifcondes,10,"0","L")."'
									and a.numlic <= '".str_pad($rifconhas,10,"0","L")."'
									and b.codtiplic >='".str_pad($caj1,6,"0","L")."'
									and b.codtiplic <='".str_pad($caj2,6,"0","L")."'
									and A.STALIC<>'C'
									and	A.STALIC<>'N'
									and	A.STALIC<>'S'
									and a.codtiplic = b.codtiplic
									and upper(a.dirpri) like '%".trim(strtoupper($direccion))."%'
									order by a.numlic";
				//print $this->sql;exit;

			}
			if ($statusl=='V'){
				//echo 'vencidas';
				$this->sql="select a.numlic,a.rifcon, a.catcon, a.nomneg,a.dirpri,b.destiplic
									from fcsollic a,fctiplic b
									where
									a.numlic >= '".str_pad($rifcondes,10,"0","L")."'
									and a.numlic <= '".str_pad($rifconhas,10,"0","L")."'
									and a.fecven <=to_date('".$fecha."','dd/mm/yyyy')
									and b.codtiplic >='".str_pad($caj1,6,"0","L")."'
									and b.codtiplic <='".str_pad($caj2,6,"0","L")."'
									and A.STALIC<>'C'
									and	A.STALIC<>'N'
									and	A.STALIC<>'S'
									and a.codtiplic = b.codtiplic
									and upper(a.dirpri) like '%".strtoupper($direccion)."%'
									order by a.numlic";
				//print $this->sql;exit;

			}
			if ($statusl=='N'){

			$this->sql="select a.numlic,a.rifcon, a.catcon, a.nomneg,a.dirpri,b.destiplic
									from fcsollic a,fctiplic b
									where
									a.numlic >= '".str_pad($rifcondes,10,"0","L")."'
									and a.numlic <= '".str_pad($rifconhas,10,"0","L")."'
									and a.fecven >=to_date('".$fecha."','dd/mm/yyyy')
									and b.codtiplic >='".str_pad($caj1,6,"0","L")."'
									and b.codtiplic <='".str_pad($caj2,6,"0","L")."'
									and A.STALIC<>'C'
									and	A.STALIC<>'N'
									and	A.STALIC<>'S'
									and a.codtiplic = b.codtiplic
									and upper(a.dirpri) like '%".strtoupper($direccion)."%'
									order by a.numlic";
							//print $this->sql;exit;

			}

	 //H::PrintR($this->sql); exit;

return $this->select($this->sql);
	}

}
?>
