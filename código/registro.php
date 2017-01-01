<?php 
require_once('./inc/cabecera.inc.php');
require_once('./Urls.php'); 

echo '<script languaje="JavaScript">
				var url_country="'.URL_country.'";
				var url_institution="'.URL_institution.'";
			</script>';

if ((isset($_COOKIE['acrsession'])) && (isset($_SESSION["token"])))
	setcookie("acrsession", $_SESSION["token"], time()+60*60*24, "/");	
?>


		<div id="main-menu">
			<?php require_once('./inc/login.inc.php'); ?>
		</div>

		<script>
			//cargamos el recaptcha
			captcha();
			
			window.onload = cargaPaises();
			window.onload = cargaInstituciones("ES");
		</script>		

		<div id="content" onload="cargaPaises()">
			<div id="container">
				<form id="form_registro" name="form_registro" action="./register.php" method="post"><!-- form registro -->
				  <table id="formularioRegistro">
						<tr height="25px"><td class="rtabform"></td><td></td></tr>
						<tr>
							<td class="rtabform"><label name="name">Nombre:</label>
							</td>
							<td class="segunda" id="celdaName">
								<input name="name" id="name" type="text"  onblur="validarName();"/>
								
							</td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="gender">Género: </label>
							  </td>
							  <td class="segunda">
								
									<select name="gender" id="gender" class="form-text" >
										<option value="MALE">Hombre</option>
										<option value="FEMALE">Mujer</option>
									</select>
								
							  </td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="birthday">Fecha de Nacimiento: </label>
							  </td>
							  <td class="segunda">
									<select name="anhoNac" id="anhoNac" onchange="ponerDias()">
									 <script>ponerAnho();</script>
									</select>
									<select name="mesNac" id="mesNac" onchange="ponerDias()">
									 <script>ponerMes();</script></select>
									<select name="diaNac" id="diaNac">
									 <script>ponerDias();</script>
									</select>
							  </td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="country">País:</label>
							  </td>
							  <td class="segunda">
									<select name="country" id="country" class="form-text" onchange="cargaInstituciones(this.value)">
										<option>Cargando...</option>
									</select>
							  </td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="institucion">Institución:</label>
							  </td>
							  <td class="segunda">
									<select name="institucion" id="institucion" class="form-text">
										<option>Selecciona antes un país</option>
									</select>
							  </td>
						</tr>
						<tr>
							  <td class="rtabform" ><label name="email">Email:</label>
							  </td>
							  <td id="celdaMail"class="segunda">
									<input name="email" id="email" type="text" class="form-text :email :required : only_on_blur" onblur="validarMail();"/> 
									
							  </td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="nick">Nick:</label>
							  </td>
							  <td id="celdaNick" class="segunda">
									<input name="nick" id="nick" type="text" class="form-text" onblur="validarNick();"/>
									
							  </td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="password">Contraseña:</label>
							  </td>
							  <td class="segunda" id="celdaPass">
									<input name="password" id="password" type="password" class="form-text :password :required : only_on_blur" onblur="validarPass();"/>
									
							  </td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="pass2">Repite contraseña:</label>
							  </td>
							  <td class="segunda">
									<input name="pass2" id="pass2" type="password" class="form-text :same_as;password :required : only_on_blur" />
									
							  </td>
						</tr>
						
						<tr>
							  <td class="rtabform"><label name="mailNotificacion">Notificación de veredictos: </label>
							  </td>
							  <td class="segunda">
									  <!-- cambiar a una unica posible -->
									
											<input type="radio" name="mailNotification" value="ALWAYS" checked> Deseo recibir notificaciones en el correo electrónico.<br/>
											<input type="radio" name="mailNotification" value="DELAYED"> Deseo recibir notificaciones <b>cuando el proceso de evaluación ha sido lento o cuando se ha vuelto a evaluar un problema ya evaluado</b>.<br/>
											<input type="radio" name="mailNotification" value="REJUDGATIONS"> Deseo recibir notificaciones <b>sólo cuando se ha vuelto a juzgar un problema ya evaluado</b>.<br/>
											<input type="radio" name="mailNotification" value="NEVER"> <b>No</b> deseo recibir nunca notificaciones en el correo electrónico.
									
								</td>
						</tr>
						<tr>
							  <td class="rtabform"><label name="captcha">Captcha:</label>
							  </td>
							  <td class="segunda">
									<div id="recaptcha"></div>
							 </td>
						</tr>
						<tr height="25px"><td class="rtabform"></td><td></td></tr>
						<tr>
							  <td colspan="2">
									<input type="submit" name="send" id="send" value="Enviar" class="form-button" onclick="this.disabled = true; " onsubmit="enviaDatos();" disabled="true"/>
							  </td>
						</tr>
				  </table>
				</form>
			</div>
		</div>

<?php require_once('./inc/pie.inc.php'); ?>
