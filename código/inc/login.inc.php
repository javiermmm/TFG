
	<div id="registro">
		<form id ="login" name="login" method="post" action="login.php">
		<?php
			//$_SESSION["user"]='PACO';
			$registrado = isset($_COOKIE["acrsession"]);
			//echo ($_SESSION["user"]);
			 if (( ! $registrado) || (! isset($_SESSION['id']))) { //Si no esta registrado
				echo "<p>Usuario:<input type='text' name='user' class='caja_login'/></p>
				<p>Contraseña:<input type='password' name='pass' class='caja_login'/></p>
				<input type='submit' value='Login' class='caja_login'/>
				<input type='hidden' name='page' value={$_SERVER['REQUEST_URI']}></input>
				<a href='recuerda.php'>¿Has olvidado tu contraseña?</a>
				<a href='registro.php'>Regístrate aquí</a>";
			} else{
				
				echo '<p id="auth" >Autentificado como:   '. htmlspecialchars($_SESSION["username"]) .  '</p>
				<a id="envios" href="ultimosEnviosUsuario.php">Mis últimos envíos</a>
				<a id="logout" href="logout.php">logout</a>
				<a id="perfil" href="usuario.php?id='.$_SESSION["id"].'">Mi perfil</a>';
				
			}
		?>
		</form>
	</div>
	
	<div id="buscar">
		<form id="envio" method="post" action="./buscar.php">
			<p>ID del problema<input type="text" name="search-text" id="search-text" class='caja_login'></input></p>
			<input type="submit" id="search-submit" value="BUSCAR" class='caja_login'></input>
		</form>
	</div>