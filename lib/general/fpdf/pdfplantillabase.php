<?php
#LECTURA DEL ARHICOV reportes.yml arreglo CriterioPdf
require_once("../../lib/yaml/Yaml.class.php");
#INCLUDES PARA MI PDF
require_once("../../lib/general/fpdf/fpdf.php");
require_once("../../lib/general/fpdf/fpdfbase.class.php");
require_once("../../lib/general/cabecera.php");
require_once("../../lib/bd/basedatosAdo.php");

class pdfplantillabase extends fpdf
{

}

?>
