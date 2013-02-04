<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SIGA Reportes</title>
<link  href="../../lib/css/siga.css" rel="stylesheet" type="text/css">
<link  href="../../lib/css/datepickercontrol.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../lib/general/datepickercontrol.js"></script>
<script language="JavaScript" src="../../lib/general/fecha.js"></script>
<style type="text/css">
<!--
.style1 {color: #0000CC}
-->
</style>
</head>
<body>
<?
require_once("../../lib/bd/basedatosAdo.php");
$bd=new basedatosAdo();
$codctades="";
$codctahas="";

global $codctades;
global $codctahas;
global $periodo;
global $jefecont;
global $contmunicipal;
global $comodin;


function LlenarTextoSql($sql,$campo1,$con)
  {
     $tb=$con->select($sql);
	 if (!$tb->EOF)
	 {
	   print $tb->fields[$campo1];
	 }
	 else
	 {
	   print "";
	 }
  }

 function LlenarComboSql($sql,$campo1,$campo2,$seleccionado,$con)
  {
     $tb=$con->select($sql);
	 while (!($tb->EOF))
	 {
	   if ($tb->fields[$campo1]==$seleccionado)
	      {
	   ?>
	      <option value="<? print $tb->fields[$campo1];?>" selected><? print $tb->fields[$campo2];?></option>
	   <?
	      }
	   else
	      {
	   ?>
	      <option value="<? print $tb->fields[$campo1];?>"><? print $tb->fields[$campo2];?></option>
	   <?
		  }
	   $tb->MoveNext();
	 }
  }

?>
<form name="form1" method="post" action="">
  <table width="760" height="40"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
    <tr>
      <td width="190" rowspan="2" bgcolor="#003399" class="cell_left_line02"><img src="../../img/tl_logo_01.gif" width="190" height="40" border="0"></a></td>
      <td colspan="2" class="cell_date" align="right">
		<?
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
		$mes = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$me=$mes[date('n')];
		echo $dias[date('w')].strftime(", %d de $me del %Y")."<br>";
		?>
		</td>
    </tr>
    <tr>
      <td width="313">&nbsp; </td>
      <td width="257" align="right" valign="middle" class="cell_logout">&nbsp;</td>
    </tr>
  </table>
  <table width="738"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="7" align="left" valign="top" class="cell_left_line02"><img src="../../img/center02_tl.gif" width="6" height="6"></td>
      <td width="694" rowspan="2" valign="top" class="cell_padding_01"> <p class="breadcrumb">Reportes
        </p>
        <fieldset>

        <div align="left">&nbsp;
          <table width="548" align="center" cellspacing="0" bordercolor="#6699CC" class="grid_line01_tl">
            <tr bordercolor="#FFFFFF">
              <td colspan="3" class="form_label_01"> <div align="center"> <font color="#000066" size="4"><strong>Balance General
                      <input name="titulo" type="hidden" id="titulo">
</strong></font></div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01">&nbsp;</td>
              <td>&nbsp;</td>
              <td><font color="#00FFCC">&nbsp; </font></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td width="141" class="form_label_01"><strong>Tama&ntilde;o Hoja:</strong></td>
              <td width="165"> <input name="tamano" type="text" class="breadcrumb" id="tamano" readonly="true"></td>
              <td width="243">&nbsp;</td>
            </tr>
            <tr bordercolor="#6699CC">
              <td height="24" class="form_label_01"><strong>Orientaci&oacute;n:</strong></td>
              <td> <input name="orientacion" type="text" class="breadcrumb" id="orientacion" readonly="true"></td>
              <td> <div align="right"> </div></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td class="form_label_01"> <div align="left"><strong>Salida del
                  Reporte:</strong></div></td>
              <td> <div align="left"> </div>
                <div align="left"> <strong>
                  <input name="radiobutton" type="radio" class="breadcrumb" value="radiobutton" checked>
                  PANTALLA</strong></div></td>
              <td> <strong>
                <input name="radiobutton" type="radio" class="breadcrumb" value="radiobutton">
                IMPRESORA</strong></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td colspan="3" class="form_label_01"> <div align="center"><font color="#000066" size="3"><strong><em>Criterios
                  de Selecci&oacute;n</em></strong></font></div></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td bordercolor="#FFFFFF" class="form_label_01">&nbsp;</td>
              <td><strong>DESDE</strong></td>
              <td><strong>HASTA</strong></td>
            </tr>
            <tr>
              <td class="form_label_01">
                <div align="left"><strong>C&oacute;digo de Cuenta:</strong></div></td>
              <td><div align="left">
                    <input name="codctades" type="text" value="<?
				$sql="select min(substr(a.codcta,1,7)) as codcta from contabb a,contaba b where b.codemp='001' and
             		(a.codcta like rtrim(b.codtes)||'%' or a.codcta like rtrim(b.codhac)||'%')";
                LlenarTextoSql($sql,"codcta",$bd);
				?>" class="breadcrumb" id="codctades" size="20" maxlength="100">
                    <input type="button" name="Button" value="..." onClick="catalogo('codctades');">
                </div></td>
                <td><div align="left"> </div>
                  <div align="left">
                    <input name="codctahas" type="text" value="<?
				$sql="select max(substr(a.codcta,1,7)) as codcta from contabb a,contaba b where b.codemp='001' and
              		(a.codcta like rtrim(b.codtes)||'%' or a.codcta like rtrim(b.codhac)||'%')";
                LlenarTextoSql($sql,"codcta",$bd);
				?>" class="breadcrumb" id="codctahas" size="20" maxlength="100">
                    <input type="button" name="Button" value="..." onClick="catalogo('codctahas');">
                </div></td>
            </tr>
            <tr>
              <td class="form_label_01"><strong>Peri&oacute;do:</strong></td>
              <td>
               <select name="periodo" class="breadcrumb" id="periodo">
				<?
   			    $sql="select distinct b.pereje from contaba a, contaba1 b where a.fecini = b.fecini and
              					a.feccie = b.feccie order by b.pereje";
				LlenarComboSql($sql,"pereje","pereje",$periodo,$bd);
				?>
				</select>
			  </td>
              <td>&nbsp;
			  </td>
            </tr>
            <tr>
              <td class="form_label_01"><strong>Jefe de Contabilidad: </strong></td>
              <td>
                <input name="jefecont" type="text" class="breadcrumb" id="jefecont" size="40" maxlength="40" value=""></td>
              <td>&nbsp;</td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01"><strong>Contador Municipal :</strong></td>
              <td>
                <input name="contmunicipal" type="text" class="breadcrumb" id="contmunicipal" size="40" maxlength="40" value=""></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01">&nbsp;</td>
              <td colspan="2">
                No dejar estos campos en blanco de lo contrario no apareceran las firmas correspondientes
                </td>
            </tr>
            <tr bordercolor="#6699CC">
              <td class="form_label_01"> <div align="left"><strong>Filtro:</strong></div></td>
              <td colspan="2"> <div align="left"></div>
                <div align="left">
                  <input name="comodin" type="text" class="breadcrumb" id="comodin" value="%" size="75">
                  <input name="sqls" type="hidden" id="sqls">
                </div></td>
            </tr>
            <tr bordercolor="#6699CC">
             <td></td>
              <td >Ej: %%-%%-%%-401-%%-%%-02 </td><td>
              Este ejemplo listara todos los codigos que en su cuarto nivel contengan 401 y en el septimo un 02</td>
            </tr>
          </table>
        </div>
        <div align="left">&nbsp; </div>
        </fieldset>
        <table width="356"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
          <tr>
            <td width="38" rowspan="3" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="258"><img src="../../img/box01_tl.gif" width="6" height="6"></td>
            <td width="60" align="right"><img src="../../img/box01_tr.gif" width="6" height="6"></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input name="Button" type="button" class="form_button01" value="Generar" onClick="enviar()">
              <input name="Button" type="button" class="form_button01" value="   Salir    " onClick="cerrar()"> </td>
          </tr>
          <tr>
            <td><img src="../../img/box01_bl.gif" width="6" height="6"></td>
            <td align="right"><img src="../../img/box01_br.gif" width="6" height="6"></td>
          </tr>
        </table></td>
      <td width="6" align="right" valign="top"><img src="../../img/center01_tr.gif" width="6" height="6"></td>
      <td width="31" rowspan="2" align="center" bgcolor="#EEEEEE">&nbsp;</td>
    </tr>
    <tr>
      <td align="left" valign="bottom" class="cell_left_line02"><img src="../../img/center02_bl.gif" width="6" height="6"></td>
      <td align="right" valign="bottom"><img src="../../img/center01_br.gif" width="6" height="6"></td>
    </tr>
  </table>
</form>
</body>
<script language="javascript">
function enviar()
{
	f=document.form1;
	f.titulo.value="BALANCE GENERAL";
	f.action="rconbalgenfis.php";
	f.submit();
}
function cerrar()
{
	window.close();
}

function catalogo(campo)
{
    pagina="../../lib/general/catalogoobj.php?campo="+campo+"&sql=select distinct(substr(a.codcta,1,7)) as Cuenta from contabb a,contaba b where b.codemp=Â¿001Â¿ and (a.codcta like rtrim(b.codtes)||Â¿%Â¿ or a.codcta like rtrim(b.codhac)||Â¿%Â¿)";
	window.open(pagina,"Catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,heigth=400,resizable=yes,left=50,top=50");
}

</script>
</html>
<?
$bd->closed();
?>
