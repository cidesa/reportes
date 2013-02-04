<?php
require_once("../../lib/modelo/baseClases.class.php");
class Nprcontra extends BaseClases {

    function sqlp($codemp) {

    	$sql2="select upper(a.nomemp) as nomemp,
    	a.cedemp,
    	a.nacemp,
    	to_char(a.fecing,'dd/mm/yyyy') as fecing,
		c.nomcar, d.desniv, c.suecar
		from nphojint a, npasicaremp b, npcargos c, npestorg d
		where a.codemp like '".($codemp)."%' and
		a.codemp=b.codemp and
		b.codcar=c.codcar and
		(a.codniv)=(d.codniv) ";


		$sql="select upper(a.nomemp) as nomemp,
    	a.cedemp,
    	a.nacemp,
    	to_char(a.fecing,'dd/mm/yyyy') as fecing, to_char(a.fecret,'dd/mm/yyyy') as fecret,
		c.nomcar, d.desniv, f.monto as suecar
		from nphojint a, npasicaremp b, npcargos c, npestorg d, npconsueldo e , npasiconemp f
		where a.codemp='".($codemp)."' and
		a.codemp=b.codemp and
		b.codcar=c.codcar and
		(a.codniv)=(d.codniv) and b.codnom=e.codnom and  e.codcon=f.codcon and a.codemp=f.codemp";
//print '<pre>';  print $sql;
    	return $this->select($sql);
    }

    function sqlempresa(){
    	$sql="select * from empresa";

    	return $this->select($sql);
    }
    function sqlnumeros($pos,$num){
    	$sql="SELECT
			(select NOMNUM from numeros where pos=$pos and num=$num) AS NUMEROS;";

		return $this->select($sql);
    }
        function promedio_historico($codemp){
    	$sql="SELECT
				sum(a.monto) as sueldo,max(a.fecnom)
				FROM nphiscon a,npconsalint b
				where
				codemp='".($codemp)."'
				and a.codcon=b.codcon and
				a.codnom=b.codnom and a.codcon not in (select codcon from npconsueldo where codnom=a.codnom)
				group by
				a.fecnom,a.codemp
				order by codemp";

		return $this->select($sql);
    }

            function promedio($codemp){
    	 $sql="SELECT
				sum(a.monto) as sueldo ,max(a.fecnom)
				FROM npnomcal a,npconsalint b
				where
				codemp='".($codemp)."'
				and a.codcon=b.codcon and
				a.codnom=b.codnom
				group by
				a.fecnom,a.codemp
				order by codemp";
//print '<pre>';  print $sql;

		return $this->select($sql);
    }

                function sueldointegral($codemp,$fecnomdes,$fecnomhas){
    	       $sql="	select sum(monto) as sueldo  from
		nphiscon a,npconsalint b, npdefcpt c
		where
		a.codcon=b.codcon and
		b.codcon=c.codcon and
		a.codnom=b.codnom and   c.afepre='S' and   c.opecon='A' and
		a.codemp='".$codemp."' and a.fecnom>=to_date('$fecnomdes','DD/MM/YYYY')
		and a.fecnom<=to_date('$fecnomhas','DD/MM/YYYY')     group by
		a.codemp
";
//print '<pre>';  print $sql;

		return $this->select($sql);
    }

        function sqlcalulasueldo($codemp,$fecnomdes,$fecnomhas)
    {
		$sql="select sum(monto) as sueldo from
		      nphiscon a,npconsueldo b
		      where
		      a.codcon=b.codcon and
		      a.codnom=b.codnom and
		      a.codemp='".$codemp."' and a.fecnom>=to_date('$fecnomdes','DD/MM/YYYY')
	          and a.fecnom<=to_date('$fecnomhas','DD/MM/YYYY')     group by
				a.codemp,monto ";
                          // H::PrintR($sql);exit;

    	return $this->select($sql);
    }

           function sqlcalulasueldointegral($codemp,$fecnomdes,$fecnomhas)
    {
		$sql="select sum(monto) as sueldo from
		      nphiscon a,npconsalint b
		      where
		      a.codcon=b.codcon and
		      a.codnom=b.codnom and
		      a.codemp='".$codemp."' and a.fecnom>=to_date('$fecnomdes','DD/MM/YYYY')
	          and a.fecnom<=to_date('$fecnomhas','DD/MM/YYYY')     group by
				a.codemp ";
                        //   H::PrintR($sql);exit;

    	return $this->select($sql);
    }

     function sqlprimas($codemp,$fecnomdes,$fecnomhas)
    {
		$sql="select sum(monto) as sueldo from
		      nphiscon a,npconsalint b, npdefcpt c
		      where
		      a.codcon=b.codcon and
		      b.codcon=c.codcon and
		      a.codnom=b.codnom and   c.afepre='S' and
		      a.codemp='".$codemp."' and a.fecnom>=to_date('$fecnomdes','DD/MM/YYYY')
	          and a.fecnom<=to_date('$fecnomhas','DD/MM/YYYY')     group by
			  a.codemp ";
                     //     H::PrintR($sql);exit;

    	return $this->select($sql);
    }




}
?>