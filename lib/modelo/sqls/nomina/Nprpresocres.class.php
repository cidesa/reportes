<?php
require_once("../../lib/modelo/baseClases.class.php");

class Nprpresocres extends baseClases
{
	function sqlp($codemp)
	{
		$dias=30;
		$sql="select *from nppresoc";
			/*print '<pre>';
        		print $sql;
        	print '<pre>';
        	exit;*/
		return $this->select($sql);
	}

	function sqldatos($codemp)
	{
		$sql="select
			a.codnom,
			f.nomnom,
			e.nomcar as cargo, a.codcar,
			b.cedemp,
			b.nomemp,
			to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy') as fecing,
			to_char(b.fecret,'dd/mm/yyyy') as fecret,
			to_char(c.feccor,'yyyy') as ano,
			c.anotra,
			c.mestra,
			c.diatra
			from
			nphiscon a,
			nppresoc c,
			nphojint b, npcargos e, npnomina f
			where
			rpad(a.codemp,16,' ')=rpad('".$codemp."',16, ' ') and
			a.codemp=b.codemp and
			a.codemp=c.codemp and
			b.codemp=c.codemp and
			a.codcar=e.codcar and
			a.codnom=f.codnom
			group by a.codnom,f.nomnom,e.nomcar, a.codcar,b.cedemp, b.nomemp, to_char(coalesce(b.fecrei,b.fecing),'dd/mm/yyyy'),to_char(b.fecret,'dd/mm/yyyy'), c.feccor,c.anotra,c.mestra,c.diatra";

			return $this->select($sql);
	}

	function sqlcate($codemp){
		$sql = "select
				b.nomcat as categoria
				from nphiscon a,npcatpre b
				where
				a.fecnom = (select max(a.fecnom)  from nphiscon a where rtrim(codemp )= rtrim('".$codemp."'))
				and a.codcat=b.codcat
				and rtrim(a.codemp)=rtrim('".$codemp."')";


		return $this->select($sql);
	}


	function sqlTiempo($codemp){
		$sql = "select a.diaser,a.messer,a.anoser from nppresocant a
				where codemp='$codemp'";
		return $this->select($sql);
	}
	function sqlTiemponuevo($codemp){
		$sql = "select a.diaser,a.messer,a.anoser from nppresoc a
				where codemp='$codemp'";
		return $this->select($sql);
	}
	function sqlCompensacionTra($codemp){
		$sql = "select
				a.capvie as saldotra,
				a.intacum as inttra,a.diadif as diatra,
				 b.salemp
				from npimppresoc1 a ,npimppresoc b
				where a.tipo='1'
				and a.fecfin=(select max(a.fecfin)  from npimppresoc1 a where tipo = '1' and rtrim(codemp )= rtrim('".$codemp."'))
				and b.fecfin=(select max(b.fecfin)  from npimppresoc b where rtrim(codemp)= rtrim('".$codemp."'))
				and a.codemp=b.codemp group by a.capvie,a.intacum,a.diadif,b.salemp,b.fecfin";

				 /*print '<pre>';
						print_r(  $sql);
						 print '</pre>';
						exit;*/
		return $this->select($sql);
	}
	function sqlCompensacionAcumulada($codemp){
		$sql="select sum (adepre) as adetra, max(fecfin) from npimppresoc1 a where tipo='1' and rtrim(codemp )= rtrim('".$codemp."')";
		return $this->select($sql);
	}
	function sqlIntereses($codemp){
		$sql = "select a.intacum as intplatra
				from npimppresoc1 a
				where
				tipo='2'
				and a.fecfin = (select max(a.fecfin)  from npimppresoc1 a where
				tipo = '2' and rtrim(codemp )= rtrim('".$codemp."'))";
		return $this->select($sql);
	}
// regimen viejo
	function sqlPrestacionesVie($codemp){
		$sql="select
			  a.antacum as previe,
			  a.intacum as intvie,
			  a.diadif as diavie, a.salemp
			  from npimppresocant a
			  where
              a.fecfin = (select max(a.fecfin)
              from npimppresocant a where rtrim(codemp )= rtrim('".$codemp."'))";
         return $this->select($sql);
	}
	function sqlAdelantoVie($codemp){
		$sql="select adepre as adetra , fecfin as fecade
 			  from npimppresocant a
			  where
			  rtrim(codemp )= rtrim('".$codemp."')
			  and a.adepre<>0";
		return $this->select($sql);
	}
	function sqlInteresesRegVie($codemp){
		$sql = "select a.intacum as intplatra
				from npimppresoc1 a
				where
				tipo='0'
				and a.fecfin = (select max(a.fecfin)  from npimppresoc1 a where tipo = '0'
				and rtrim(codemp )= rtrim('".$codemp."') )";
		return $this->select($sql);
	}
// regimen nuevo
	function sqlPrestacionesNue($codemp){
		$sql ="select
				a.antacum as prenue,
				a.intacum as intnue,
				a.diadif as dianue, a.salemp
				from npimppresoc a
				where
				a.fecfin = (select max(a.fecfin)  from npimppresoc a where rtrim(codemp )= rtrim('".$codemp."'))
				and tipo is null";
		return $this->select($sql);
	}

	function sqlClaus($codemp){
		$sql ="select sum (a.valart108) as valor,sum (a.diaart108) as dia
			  from npimppresoc a   where rtrim(codemp )= rtrim('".$codemp."')";
			  return $this->select($sql);
	}

// -----------------------sql nuevos por imprimir y probar ok-------------------------------------

	function sqladelantonuevo($codemp){
		$sql ="select adepre as adetra , fecfin as fecade
			 from npimppresoc a
			where
			rtrim(codemp )= rtrim('".$codemp."')
			and a.adepre <>0
			and tipo is null";
		return $this->select($sql);
	}

	function sqlconceptos($codemp,$codcar,$ano,$tipo){

		$sql="SELECT
							coalesce(sum(A.monto),0) as saldo,
							A.FECNOM
							FROM
							NPhiscon A
							left outer join NPCARGOS B on (A.CODCAR=B.CODCAR)
							left outer join NPDEFCPT D on (A.CODCON=D.CODCON)
							WHERE
							A.CODCON IN (SELECT DISTINCT Z.CODCON FROM NPHISCON Z WHERE UPPER(Z.NOMCON) LIKE UPPER('".$tipo."')) AND
							TRIM(A.CEDEMP) = TRIM('".$codemp."') AND
							TRIM(A.CODCAR) = TRIM('".$codcar."') AND
							TO_CHAR(A.FECNOM,'yyyy') = '".$ano."'
							GROUP BY A.FECNOM";
							return $this->select($sql);

	}

// asignaciones para el ultimo corte
	function sqlasignaciones($codnom,$codemp,$fecret){
		$sql ="select sum(monto) as asignaciones from npconsalint a, nphiscon b , npdefcpt  c where
				a.codnom='".$codnom."'
				and rtrim(codemp)= rtrim('".$codemp."')
				and b.fecnom <'".$fecret."'
				and b.fecnom=(select max( fecnom) from nphiscon where rtrim(codemp) =rtrim('".$codemp."') )
				and a.codnom=b.codnom
				and a.codcon=b.codcon
				and a.codcon=c.codcon
				and opecon='A'";

		return $this->select($sql);
			}
// esta funcion es para devolver la platica
	function sqlreintegro($codemp){
		$sql ="select adepre as adetra , fecfin as fecade
			 from npimppresoc a
			where
			rtrim(codemp )= rtrim('".$codemp."')
			and a.adepre <>0
			and tipo is null";
		return $this->select($sql);
	}
// sql para las deducciones
	function sqldec($codemp){
		$sql ="select concepto, monto from npliquidacion_det where rtrim(codemp)=rtrim('".$codemp."') and rtrim(asided) =rtrim('D')";
		return $this->select($sql);
	}



//--------------------------------------------------------------------------------------------------//
}