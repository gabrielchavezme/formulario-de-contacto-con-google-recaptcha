<?php require "enviar.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php if(isset($alerta)) echo $alerta;  ?>
	<form action="" accept-charset="utf-8" method="post">
		<input type="hidden" name="csrf" value="<?php echo $_SESSION["token"]; ?>">
		<input type="text" name="nombre" placeholder="Nombre completo" required/>
		<br>
		<br>
		<input type="tel" name="telefono" placeholder="Telefono de contacto" required/>
		<br>
		<br>
		<input type="email" name="correo" placeholder="Correo de contacto" required/>
		<br>
		<br>
		<textarea name="mensaje" placeholder="Mensaje..." required></textarea>
		<br>
		<?php  echo '<div class="g-recaptcha" data-sitekey="'.$yourpublickey.'"></div>';?>
		 <br>
		<input name="submit" type="submit" value="Enviar">
	</form>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>