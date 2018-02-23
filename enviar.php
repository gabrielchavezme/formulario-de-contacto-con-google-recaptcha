<?php
session_start();
$_SESSION["token"] = md5(uniqid(mt_rand(), true));
require "config.php";
  ini_set('display_errors',1);  error_reporting(E_ALL);
  if(!empty($_POST["csrf"]) && !empty($_POST["csrf"]) == $_SESSION["token"]){
      $userIP = $_SERVER["REMOTE_ADDR"];
      $recaptchaResponse = $_POST['g-recaptcha-response'];
      $secretKey = $yoursecretkey;
      $request = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$userIP}");
      if(!strstr($request, "true")){
          echo '<script>alert("Hay un problema! por favor completa correctamente el captcha...");</script>';
      }
      else{
        if(isset($_POST['nombre']) && isset($_POST['correo']) && isset($_POST['telefono'])) 
        {
        $message=
        '<strong>Nombre:</strong> '.$_POST['nombre'].'<br /> <br />
        <strong>Telefono:</strong>  '.$_POST['telefono'].'<br /> <br />
        <strong>Correo:</strong>  '.$_POST['correo'].'<br /> <br />
        <strong>Mensaje:</strong>   '.$_POST['mensaje'].' <br /> <br /> <hr>
        <p><strong>Datos de envio</strong>:</p>
        <strong>Enviado desde:</strong> '.$_SERVER['HTTP_HOST'].' <br>
        <strong>IP:</strong> '.$userIP.'
        ';
            require "mailer/class.phpmailer.php";
            $mail = new PHPMailer();  
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = "tls";
            $mail->Host = $host;
            $mail->Port = 587;
            $mail->Encoding = '7bit';
            $mail->Username   = $senderEmail;
            $mail->Password   = $senderPassword;
            $mail->SetFrom($_POST['correo'], $_POST['nombre']);
            $mail->AddReplyTo($_POST['correo'], $_POST['nombre']);
            $mail->Subject = "Formulario de contacto"; 
            $mail->MsgHTML($message);
            $mail->AddAddress("$receiver", $receiverName);
            $result = $mail->Send();
            $alerta = $result ? '<script>alert("Hemos recibido tu mensaje, nos pondremos en contacto contigo a la brevedad posible.");</script>' : '<script>alert("Hubo un error y no hemos podido entregar tu mensaje, vuelve a intentarlo.");</script>';
            session_destroy();
            unset($mail);
        }
      }
  }
?>
