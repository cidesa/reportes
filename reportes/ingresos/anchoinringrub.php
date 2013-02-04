<?
require_once("../../lib/bd/basedatosAdo.php");
class mysreportes
{

function getAncho($pos)
  {
    $anchos=array();
    $anchos[0]=10;
    $anchos[1]=30;
    $anchos[2]=15;
    $anchos[3]=15;
    $anchos[4]=15;
    $anchos[5]=15;
    $anchos[6]=15;
    $anchos[7]=15;
    $anchos[8]=15;
    $anchos[9]=15;
    $anchos[10]=15;
    $anchos[11]=15;
    $anchos[12]=15;
    $anchos[13]=15;
    $anchos[14]=15;

    return $anchos[$pos];
  }


}
?>