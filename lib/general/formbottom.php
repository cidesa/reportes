
            <tr>
            <td>
            </td>
            </tr>
             </table>
        <table width="356"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
          <tr>
            <td colspan="2" align="center">
              <input class="sf_admin_action_save" type="button" onclick="enviar();" value="Generar"/>
              <input class="sf_admin_action_save" type="button" onclick="cerrar();" value="Salir"/>
            </td>
          </tr>
        </table>
            </td>
            </tr>
            </table>
            </td>
            </tr>
          </table>
        </div>
        </fieldset>
        </div>
      </td>
    </tr>

  </table>
  </div>
  </td>
  </tr>
</table>
<?php require_once('../../lib/general/bottom.php'); ?>
</form>
</body>
<script language="javascript">
function enviar()
{
  var jasper= "<?php echo $jasper?>";
  f=document.form1;
  f.titulo.value="<?php echo strtoupper($titulo)?>";                                          //CAMBIAR TÍTULO    
  if(jasper=='S')
    f.action="../jasper.php?m=<?php echo TraerModuloReporte()?>&r=<?php echo TraerNombreReporte()?>&s=<?php echo $_SESSION['schema']?>";  
  else  
    f.action="r.php?m=<?php echo TraerModuloReporte()?>&r=<?php echo TraerNombreReporte()?>";                                    //CAMBIAR NOMBRE DEL REPORTE
                                    //CAMBIAR NOMBRE DEL REPORTE
  f.submit();
}
function cerrar()
{
  window.close();
}
function MostrarTipo(id)
{
   if ($(id).value=='SI')
      $('tipnom').show();
   else
      $('tipnom').hide();

}
</script>
<?php $bd->closed();?>
</html>

