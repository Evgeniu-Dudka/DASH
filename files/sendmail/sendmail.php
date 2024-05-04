<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';
	require 'phpmailer/src/SMTP.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = '';                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = '';                     //SMTP username
	$mail->Password   = '';                               //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Port       = 465;                 
	

	//Від кого лист
	$mail->setFrom('', ''); // Вказати потрібний E-mail
	//Кому відправити
	$mail->addAddress(''); // Вказати потрібний E-mail
	//Тема листа
	$mail->Subject = 'Заявка DASH';

	//Тіло листа
	$body = '<h1>Заявка</h1>';

	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>ФИО:</strong> '.$_POST['name'].'</p>';
	}	
	if(trim(!empty($_POST['telephone']))){
		$body.='<p><strong>Номер телефона:</strong> '.$_POST['telephone'].'</p>';
	}	
	if(trim(!empty($_POST['mail']))){
		$body.='<p><strong>Почта:</strong> '.$_POST['mail'].'</p>';
	}	
	
	
    if (!empty($_FILES['image']['tmp_name'])) {
        // Получаем содержимое файла
        $fileContent = file_get_contents($_FILES['image']['tmp_name']);
        
        // Добавляем содержимое файла как вложение в письмо
        $mail->addStringAttachment($fileContent, $_FILES['image']['name']);
        }

	$mail->Body = $body;

	//Відправляємо
	if (!$mail->send()) {
		$message = 'eror';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>