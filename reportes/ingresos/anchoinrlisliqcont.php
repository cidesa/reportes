<?
require_once("../../lib/bd/basedatosAdo.php");
class mysreportes
{

function getAncho($pos)
	{
		$anchos=array();
		$anchos[0]=40;
		$anchos[1]=80;
		$anchos[2]=25;

		return $anchos[$pos];
	}

	function getAncho2($pos)
	{
		$anchos2=array();
		$anchos2[0]=100;
		$anchos2[1]=20;
		$anchos2[2]=20;
		$anchos2[3]=20;
		$anchos2[4]=20;

		return $anchos2[$pos];
	}

}
?>