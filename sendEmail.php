<?php
    function sendEmail($item, $mensagem, $avaliacao, $user, $date){
    
        require("./PHPMailer_5.2.0/class.phpmailer.php");
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com;smtp-relay.gmail.com';  // Specify main and backup SMTP servers
        $mail->Port = 587;
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'reservascoltec@gmail.com';                 // SMTP username
        $mail->Password = 'reservas123';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
        $mail->From = 'reservascoltec@gmail.com';
        $mail->FromName = 'Contato Reservas';
        $mail->addAddress('gomes.nunes.bernardo@gmail.com');               // Name is optional
        $mail->addCC('nunesbernardo2000@gmail.com');
        $mail->WordWrap = 100;
        $mail->Subject = "Avaliacao de um item";
        $mail->isHTML(true);
        $mail->Body = "<b>Item</b>: $item<br>
<b>Data da reserva</b>: $date<br>
<b>Usuário</b>: $user<br>
<b>Avaliação (1 a 5)</b>: $avaliacao<br>
<b>Mensagem</b>: $mensagem<br>";

        if(!$mail->send()) {
            $return = 'A mensagem não foi enviada. Erro: ' . $mail->ErrorInfo;
        } else {
            $return = 'A mensagem foi enviada com sucesso';
        }

        return $return;
    }
?> 
