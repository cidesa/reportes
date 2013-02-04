<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

Class Jasper{
    
    function Jasper() {
  }
  
  public static function GetPost($variable)
  {
    if (isset($_POST[$variable])){
      return trim($_POST[$variable]);
    }
    elseif(isset($_GET[$variable]))
    {
      return trim($_GET[$variable]);
    }else return "";
  }
  
  public static function CargarReportesenJasper()
  {
        $schema=J::GetPost('s');
        $reporte=str_replace(".php","",J::GetPost('r'));
        $modulo=J::GetPost('m');
        $parametros = J::LecturaParametros();
        //print "java -Djava.awt.headless=true -jar ../lib/java/reportesjasper.jar $schema $modulo $reporte $parametros";exit;
        exec("java -Djava.awt.headless=true -jar ../lib/java/reportesjasper.jar $schema $modulo $reporte $parametros",$return);
        //print_r($return);
        return $return;
  }
  
  public static function LecturaParametros()
  {      
      $arrparam = array_slice($_POST,1);
      $parametros = implode(" ",$arrparam);
      return $parametros;
  }
  
} 


class J extends Jasper
{

}
?>
