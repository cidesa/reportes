<?php
require_once("../../lib/modelo/baseClases.class.php");

class Oceinst1232 extends baseClases
{
	function sqlp($coddes,$codhas,$formu)
	{

$sql= "select tipo, cuenta,buscardescripcion(tipo,cuenta) as desccta, saldocta1(tipo,cuenta,'$periodo1','$periodo2') as monanoact,
                     saldoctareal(tipo,cuenta,'00') as monulest

                     from forcfgrepins where  cuenta>='".$coddes."' and cuenta<='".$codhas."' and  nrofor='".$formu."' order by orden";



		/*$sql= "Select cuenta, desccta
				 from forcfgrepins
				 where  cuenta>='".$coddes."' and cuenta<='".$codhas."' and
				nrofor ='1234' order by cuenta";*/
//H::printR($sql);
		return $this->select($sql);

	}

     function sqlp1($tipo,$cta,$periodo)//para buscar un solo periodo
	{

$sql= "select saldocta('$tipo','$cta','$periodo') as monanoact,
                     saldoctareal('$tipo','$cta','$periodo') as monulest";
                    return $this->select($sql);
                     //H::printR($sql);

	}

	function sqlcta($periodo)//para buscar un solo periodo
	{

$sql= "select salprgper as monanoact from contabb1 where pereje = '".$periodo."' and codcta in (select cuenta from forcfgrepins where nrofor = '0408')
";
//H::printR($sql);exit;
                     return $this->select($sql);

	}

    function pasmaspat()//para buscar un solo periodo
	{

$sql= "select((select sum(salprgper) as monanoact from contabb1 where codcta  in (select cuenta from forcfgrepins where nrofor = '0408' and cuenta like 3||'%'))+
(select sum(salprgper) as monanoact from contabb1 where codcta  in (select cuenta from forcfgrepins where nrofor = '0408' and cuenta like 4||'%')))
as sumatoria";
//H::printR($sql);exit;
                     return $this->select($sql);

	}

    function sqlue($cuenta)
	{

      $ano_ue=(date("Y")-1);
      $ano=sprintf($ano_ue);
      $esquema = H::getObtenerSchema($ano);

      $sql= "select saldocta(tipo,cuenta,'00') as monulest
                     from forcfgrepins where  cuenta='".$cuenta."' and  nrofor='0408' order by orden";
   // H::PrintR($sql);print $esquema;//exit;
      return $this->select($sql,$esquema);
	}

    function sqlar($cuenta)
	{

      $ano_ar=(date("Y")-2);
      $ano=sprintf($ano_ar);
      $esquema = H::getObtenerSchema($ano);

      $sql= "select saldoctareal(tipo,cuenta,'00') as monreal
                     from forcfgrepins where  cuenta='".$cuenta."' and  nrofor='0408' order by orden";

	  return $this->select($sql,$esquema);
	}
	/*function sqlp1($codobr)
	{

		$sql=" select a.desobr,b.codpar,c.despar,b.canobr, b.cosuni
 from ocregobr a, ocdefpar c, ocpreobr b
 where a.codobr = b.codobr and b.codpar = c.codpar and a.codobr='".$codobr."'";

		return $this->select($sql);
		//print $sql; exit;
	}*/

}
?>
