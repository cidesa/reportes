<?
	
	require_once("pdfoprdetord_anulacion_definitiva.php");
	
	
	$obj= new pdfreporte();
	
#	$obj->AddPage();
#	$obj->AliasNbPages(); 
#	$obj->Cuerpo();
#	$obj->Output();
$tb=$obj->bd->select($obj->sql);
if (!$tb->EOF) 
{ //HAY DATOS  
	$obj->AliasNbPages(); 
	$obj->AddPage();
	$obj->Cuerpo();
	$obj->Output();
}		
else
{ //NO HAY DATOS
  ?> 
   <script>
   alert('No hay informacion para procesar este reporte...');
   location=("oprdetord_anulacion_definitiva.php");
   </script>
  <?
}	
?>