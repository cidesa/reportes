<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SIGA Reportes</title>
<link href="../../lib/css/siga.css" rel="stylesheet" type="text/css">
<link href="../../lib/css/datepickercontrol.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../lib/general/datepickercontrol.js"></script>
</head>
<body>
<?
require_once("../../lib/bd/basedatosAdo.php");
$bd=new basedatosAdo();
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
  <table width="760"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td width="6" align="left" valign="top" class="cell_left_line02"><img src="../../img/center02_tl.gif" width="6" height="6"></td>
      <td rowspan="2" valign="top" class="cell_padding_01"> <p class="breadcrumb">Reportes
        </p>
        <fieldset>

        <div align="left">&nbsp;
          <table width="612"  border="0" align="center" cellspacing="0" bordercolor="#6699CC" class="grid_line01_tl">
            <tr bordercolor="#FFFFFF">
              <td colspan="3" class="form_label_01"> <div align="center"> <font color="#000066" size="4"><strong>CONCILIACION
                  BANCARIA DESE HISTORICO
                  <input name="titulo" type="hidden" id="titulo">
                  </strong></font></div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01">&nbsp;</td>
              <td>&nbsp;</td>
              <td><font color="#00FFCC">&nbsp; </font></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td width="186" class="form_label_01"><strong>Tama&ntilde;o Hoja:</strong></td>
              <td width="174"> <input name="tamano" type="text" class="breadcrumb" id="tamano" readonly="true"></td>
              <td width="238">&nbsp;</td>
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
              <td class="form_label_01"> <div align="left"><strong>Nro. Cta. Bancaria:</strong></div></td>
              <td> <div align="left">
                  <?

			  	$tb=$bd->select("SELECT DISTINCT(numcue) FROM TSDEFBAN ORDER BY numcue");
			  ?>
                  <select name="cta1" class="breadcrumb" id="cta1">
                    <?
				  	while(!$tb->EOF)
					{
				  ?>
                    <option value="<? print $tb->fields["numcue"];?>"><? print $tb->fields["numcue"];?></option>
                    <?
					$tb->MoveNext();
					}
				?>
                  </select>
                </div></td>
              <td>
                <?

			  	$tb2=$bd->select("SELECT DISTINCT(numcue) FROM TSDEFBAN ORDER BY numcue desc");
			  ?>
                <select name="cta2" class="breadcrumb" id="cta2">
                  <?
				  while(!$tb2->EOF)
				{
			  ?>
                  <option value="<? print $tb2->fields["numcue"];?>"><? print $tb2->fields["numcue"];?></option>
                  <?
				  $tb2->MoveNext();
					}
				?>
                </select></td>
            </tr>
            <tr>
              <td height="30" class="form_label_01"> <p><strong>Mes</strong><strong>:</strong></p></td>
              <td colspan="2"> <select name="mes" class="breadcrumb" id="mes">
                  <option value="01">Enero</option>
                  <option value="02">Febrero</option>
                  <option value="03">Marzo</option>
                  <option value="04">Abril</option>
                  <option value="05">Mayo</option>
                  <option value="06">Junio</option>
                  <option value="07">Julio</option>
                  <option value="08">Agosto</option>
                  <option value="09">Septiembre</option>
                  <option value="10">Octubre</option>
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>
                </select></td>
            </tr>
            <tr>
              <td height="30" class="form_label_01"> <p><strong>A&ntilde;o</strong><strong>:</strong></p></td>
              <td colspan="2">
                <?

			  	$tb=$bd->select("SELECT DISTINCT TO_CHAR(feclib,'YYYY') as feclib FROM TSMOVLIB ORDER BY TO_CHAR(feclib,'YYYY') desc");
			  ?>
                <select name="ano" class="breadcrumb" id="ano">
                  <?
				  	while(!$tb->EOF)
					{
				  ?>
                  <option value="<? print $tb->fields["feclib"];?>"><? print $tb->fields["feclib"];?></option>
                  <?
					$tb->MoveNext();
					}
				?>
                </select> </td>
            </tr>
            <tr>
              <td class="form_label_01"><strong>Aprobado por:</strong></td>
              <td colspan="2"><input name="apro" type="text" class="breadcrumb" id="apro"></td>
            </tr>
            <tr>
              <td class="form_label_01"> <div align="left"><strong>Elaborado por:</strong></div></td>
              <td colspan="2"> <div align="left">
                  <input name="ela" type="text" class="breadcrumb" id="ela">
                </div></td>
            </tr>
            <tr>
              <td colspan="3" class="form_label_01">&nbsp;</td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01"><input name="sqls" type="hidden" id="sqls"></td>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
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
      <td width="40" rowspan="2" align="center" bgcolor="#EEEEEE">&nbsp;</td>
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
	f.titulo.value="HISTORICO DE CONCILIACION BANCARIA ";
	f.action="rTSRCONCILHISCMC.php";
	f.submit();
}
function cerrar()
{
	window.close();
}
function catalogo1()
{
 	pagina="catalogoform.php?campo=codpre1&sql=select codpre as campo1 from cpimpcom order by codpre asc";
	window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=300,height=200,rezizable=yes, left=100,top=100");
}
function catalogo2()
{
 	pagina="catalogoform.php?campo=codpre2&sql=select codpre as campo1 from cpimpcom order by codpre desc";
	window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=300,height=200,rezizable=yes, left=100,top=100");
}
</script>
</html>
