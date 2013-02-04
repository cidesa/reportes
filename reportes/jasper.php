<?php
require_once("../lib/yaml/Yaml.class.php");
$rutabase = implode("/",explode("/",$_SERVER['SCRIPT_FILENAME'],-2));
require $rutabase.'/lib/general/Jasper.class.php';

$r=str_replace(".php","",J::GetPost('r'));
$m=J::GetPost('m');
$opciones = Yaml::load("$m/$r.yml");
$generatxt=isset($opciones["Parametros"]["generatxt"]) ? $opciones["Parametros"]["generatxt"] : 'N';


$return = J::CargarReportesenJasper();
if(is_array($return))
{
    $file = "";
    if(isset($return[0]))
      if(file_exists($return[0])) $file=$return[0];
    if(isset($return[1]))
      if(file_exists($return[1])) $file=$return[1];

    $aux = explode("/",$file);
    $filepdf = $aux[count($aux)-1];

    if(file_exists($file))
    {
        $tam = filesize($file);
        header("Content-Length: $tam");
        
        if($generatxt=='S'){
          header ("Content-Disposition: attachment; filename=reporte.txt;" );
          header ("Content-Type: application/force-download");            
        }
        else{
          header("Content-type: application/pdf");
          header("Content-Disposition: inline; filename=reportePDF.pdf");
        }
        readfile($file);
        unlink($file);
    }else
    {?>
       <script>
          alert("Archivo de Reporte no Generado. (<?php echo implode(', ',$return) ?>)");
          location="<?php echo J::GetPost('m')."/".J::GetPost('r') ?>";
       </script>
    <?php }
}else
    {?>
       <script>
          alert("Archivo de Reporte no Generado. (<?php echo implode(', ',$return) ?>)");
          location="<?php echo J::GetPost('m')."/".J::GetPost('r')?>";
       </script>
    <?php }


?>
