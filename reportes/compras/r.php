<?php
include_once("../../lib/general/Herramientas.class.php");


require_once("../../lib/yaml/Yaml.class.php");
$rutabase = implode("/",explode("/",$_SERVER['SCRIPT_FILENAME'],-3));
$rutareporte = implode("/",explode("/",$_SERVER['SCRIPT_FILENAME'],-1));
require $rutabase.'/lib/general/Jasper.class.php';
$r=str_replace(".php","",J::GetPost('r'));

if(file_exists("$rutareporte/$r.yml")){//0
  $opciones = Yaml::load("$rutareporte/$r.yml");


// print_r($r);

  if(isset($opciones["Parametros"]["jasper"])){//1

   echo "aqui2 ";

    if($opciones["Parametros"]["jasper"]=='S'){//2
      $_GET['m'] = $opciones["Parametros"]["modulo"];
      $return = J::CargarReportesenJasper();
      if(is_array($return))
      {//3
          $file = "";
          if(isset($return[0]))
            if(file_exists($return[0])) $file=$return[0];
          if(isset($return[1]))
            if(file_exists($return[1])) $file=$return[1];

          $aux = explode("/",$file);
          $filepdf = $aux[count($aux)-1];

          if(file_exists($file))
          {//4
              $tam = filesize($file);
              header("Content-Length: $tam");

              if($generatxt=='S'){//5
                header ("Content-Disposition: attachment; filename=reporte.txt;" );
                header ("Content-Type: application/force-download");
              }//5
              else{
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=reportePDF.pdf");
              }
              readfile($file);
              unlink($file);
          }else//4
          {  ?>
            <script>
                alert("Archivo de Reporte no Generado. (<?php echo implode(', ',$return) ?>)");
                location="<?php echo J::GetPost('r') ?>";
            </script>
          <?php }
      }else//3
          {
          echo "hhhhhhhhh";
          ?>
            <script>
                alert("Archivo de Reporte no Generado. (<?php echo implode(', ',$return) ?>)");
                location="<?php echo J::GetPost('r')?>";
            </script>
          <?php }
      
    }//2
  }//1
 // else{echo "aaaaaaaaa";}
}else//0
{ //echo "aqui no";
  $reporte = H::GetPost("r");
  $modulo = H::GetPost("m");
  if (strrpos($reporte, "?")) {
    $varaux = explode("?", $reporte);
    $reporte = $varaux[0];
  }
  //require_once($modulo."/pdf".$reporte."");
  require_once("pdf" . $reporte);

  $obj = new pdfreporte();
//echo "aqui3 ";
  if ($obj->arrp) {
    $obj->AliasNbPages();
    $obj->AddPage();
    $obj->Cuerpo();
    $obj->Output();
    if ($obj->bd)
      $obj->bd->closed();
  }else {
    ?><script language="JavaScript" type="text/javascript">
              alert('No Existen Datos Para este Reporte');
              location="<?php echo $reporte ?>";
    </script><?
  }
  
}



