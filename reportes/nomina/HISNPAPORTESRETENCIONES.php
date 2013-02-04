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
          <table width="677"  border="0" align="center" cellspacing="0" bordercolor="#6699CC" class="grid_line01_tl">
            <tr bordercolor="#FFFFFF">
              <td colspan="3" class="form_label_01"> <div align="center"> <font color="#000066" size="4"><strong>APORTES
                  PATRONALES
                  <input name="titulo" type="hidden" id="titulo">
                  </strong></font></div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td class="form_label_01">&nbsp;</td>
              <td>&nbsp;</td>
              <td><font color="#00FFCC">&nbsp; </font></td>
            </tr>
            <tr bordercolor="#6699CC">
              <td width="300" class="form_label_01"><strong>Tama&ntilde;o Hoja:</strong></td>
              <td width="166"> <input name="tamano" type="text" class="breadcrumb" id="tamano" readonly="true"></td>
              <td width="197">&nbsp;</td>
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
              <td class="form_label_01"> <div align="left"><strong>T. Aporte / Retencion:</strong></div></td>
              <td> <div align="left">

              <input name="codtipapodes" type="text"  value="<?
                $sql="SELECT min(CODTIPAPO) as codtipapo FROM NPTIPAPORTES ";
                LlenarTextoSql($sql,"codtipapo",$bd);
				?>" class="breadcrumb" id="codtipapodes" size="20" maxlength="50">
                <input type="button" name="Button3" value="..." onClick="catalogo1('codtipapodes');">

                </div></td>

            </tr>
            <tr>
              <td class="form_label_01"> <div align="left"><strong>C&oacute;digo
                  Empleado:</strong></div></td>
              <td> <div align="left">

               <input name="codempdes" type="text"  value="<?
                $sql="SELECT min(CODEMP) as codemp FROM NPASICAREMP";
                LlenarTextoSql($sql,"codemp",$bd);
				?>" class="breadcrumb" id="codempdes" size="20" maxlength="50">
                <input type="button" name="Button3" value="..." onClick="catalogo2('codempdes');">

                </div></td>
              <td>

               <input name="codemphas" type="text"  value="<?
                $sql="SELECT max(CODEMP) as codemp FROM NPASICAREMP";
                LlenarTextoSql($sql,"codemp",$bd);
				?>" class="breadcrumb" id="codemphas" size="20" maxlength="50">
                <input type="button" name="Button3" value="..." onClick="catalogo2('codemphas');">

              </td>
            </tr>
            <tr>
              <td class="form_label_01"> <div align="left"><strong>Tipo N&oacute;mina:</strong></div></td>
              <td colspan="2"> <div align="left">
                  <?

			  	$tb=$bd->select("SELECT CODNOM,NOMNOM
								FROM NPNOMINA
								ORDER BY CODNOM");
			  ?>
                  <select name="tipnomdes" class="breadcrumb" id="tipnomdes">
                    <?
				  	while(!$tb->EOF)
					{
				  ?>
                    <option value="<? print $tb->fields["codnom"];?>"><? print $tb->fields["codnom"]." - ".$tb->fields["nomnom"];?></option>
                    <?
					$tb->MoveNext();
					}
				?>
                  </select>
                </div></td>
            </tr>

            <tr>
            	<td class="form_label_01"> <div align="left"><strong>Fecha de Nomina</strong></div></td>
              <td> <div align="left">

               <input name="fecdesde" type="text"  value="<?
                $sql="SELECT to_char(min(FECNOM),'dd/mm/yyyy') as fecnom FROM NPHISCON";
                LlenarTextoSql($sql,"fecnom",$bd);
				?>" class="breadcrumb" id="fecdesde" size="20" maxlength="50" datepicker="true">

                </div></td>
              <td>

               <input name="fechasta" type="text"  value="<?
                $sql="SELECT to_char(max(FECNOM),'dd/mm/yyyy') as fecnom FROM NPHISCON";
                LlenarTextoSql($sql,"fecnom",$bd);
				?>" class="breadcrumb" id="fechasta" size="20" maxlength="50" datepicker="true">

              </td>

            </tr>
                   <tr>
              <td height="26" class="form_label_01"> <div align="left"><strong>Nomina
                  Especial: </strong></div></td>
              <td colspan="2" valign="middle"> <select name="especial" class="breadcrumb" id="especial">
                  <option value="N" selected="selected">No</option>
                  <option value="S">Si</option>
                </select></td>
</tr>
            <tr>
              <td class="form_label_01"><strong>Elaborado por:</strong></td>
              <td colspan="2"><input name="elab" type="text" class="breadcrumb" id="elab" size="80"></td>
            </tr>
            <tr>
              <td class="form_label_01"><strong>Revisado por:</strong></td>
              <td colspan="2"><input name="rev" type="text" class="breadcrumb" id="rev" size="80"></td>
            </tr>
            <tr>
              <td class="form_label_01"><strong>Autorizado por:</strong></td>
              <td colspan="2"><input name="auto" type="text" class="breadcrumb" id="auto" size="80"></td>
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
	f.titulo.value="RELACION DE APORTES Y RETENCIONES";
	f.action="rHISNPAPORTESRETENCIONES.php";

	f.submit();
}
function cerrar()
{
	window.close();
}
function catalogo1(campo)
{
 	mysql='SELECT distinct CODTIPAPO as codigo ,DESTIPAPO as descripcion FROM NPTIPAPORTES  order by CODTIPAPO';
    pagina="../../lib/general/catalogoobj.php?sql="+mysql+"&campo="+campo;
	window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=400,resizable=yes,left=50,top=50");
}
function catalogo2(campo)
{
 	mysql='SELECT distinct(CODEMP) as codigo, nomemp as nombre FROM NPASICAREMP order by codemp';
    pagina="../../lib/general/catalogoobj.php?sql="+mysql+"&campo="+campo;
	window.open(pagina,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=500,height=400,resizable=yes,left=50,top=50");
}
</script>
</html>
