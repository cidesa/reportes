<?

	require_once("pdfconbalgen.php");

	$obj= new pdfreporte();

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
   alert('No hay informaciÃ³n para procesar Este reporte...');
   location=("conbalgen.php");
   </script>
  <?
}
?>