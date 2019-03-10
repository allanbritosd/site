<?php



$txt = $_POST['name']." <".$_POST['email'].">\n".$_POST['message']."\n===\n";
$myfile = fopen("emails.txt", "a") or die(json_encode(['status' => 201, 'type' => 'error', 'message' => 'Falha ao enviar email, por favor entre em contato pelos meios alternativos!']));
fwrite($myfile, $txt);
fclose($myfile);

echo json_encode(['status' => 200, 'type' => 'success', 'message' => 'Email enviado com sucesso!']);
exit;

require_once("lib/PHPMailer/src/PHPMailer.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
define('GUSER', 'allanbritosd@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', '6232547absD');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 1;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 465;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

 if (smtpmailer('falecom@allanbrito.com.br', 'allanbritosd@gmail.com', 'Allan Brito', 'Contato pelo Site', $_POST['message'])) {

 	die('sucesso');
}
if (!empty($error)) echo $error;
