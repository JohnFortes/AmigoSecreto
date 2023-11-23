<?php

namespace AmigoSecreto\Class;

use PHPMailer\PHPMailer\PHPMailer;
use \Rain\Tpl;

class Mailer {
    
    const USERNAME = "email@teste.com.br";
    const PASSWORD = "123456";

    private $mail;

	public function __construct($emailDestino, $assunto, $tplName, $data = array(), 
    $email_remetente = 'naoresponder@teste.com.br', $nome_remetente = 'Nome Remetente', 
    $nomeTo = null  ,$email_To = null, 
    $emailOculto = null, $emailCopia = null, $caminho = null, $nomeArquivo = null)
	{

		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"         => false
	   );

		Tpl::configure( $config );

		$tpl = new Tpl;

		foreach ($data as $key => $value) {
			$tpl->assign($key, $value);
		}

		$html = $tpl->draw($tplName, true);

        $emailDestin = explode(',', $emailDestino);

        /**
         * This example shows making an SMTP connection with authentication.
         */
        
        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        //date_default_timezone_set('Etc/UTC');
        
        //require '../PHPMailerAutoload.php';
        
        //Create a new PHPMailer instance
        $this->mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $this->mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = 0;

        //Ask for HTML-friendly debug output
        $this->mail->Debugoutput = 'html';

        //Set the hostname of the this->mail server
        $this->mail->Host = "email.host.com.br";

        //Set the SMTP port number - likely to be 25, 465 or 587
        $this->mail->Port = 587;

        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = true;

        //Username to use for SMTP authentication
        $this->mail->Username = Mailer::USERNAME;

        //Password to use for SMTP authentication
        $this->mail->Password = Mailer::PASSWORD;

        //Set who the message is to be sent from
        $this->mail->setFrom($email_remetente);

        $this->mail->FromName = $nome_remetente;

        //Set an alternative reply-to address
        if($email_remetente == 'naoresponder@teste.com.br'){
            $nomeTo = 'Nome Remetente';
            $email_To = 'contato@teste.com.br';
        }

        if(!empty($email_To)){
                
            $this->mail->AddReplyTo($email_To, $nomeTo);
        }
        
        //Set who the message is to be sent to
        foreach ($emailDestin as $nome => $copia) {
            //echo $copia ;
            //tirado a variavel $nome
            $this->mail->AddAddress($copia);
        }

        // Define o(s) Copia(s)
        if (!empty($emailCopia)) {
            foreach ($emailCopia as $nome => $copia) {
            $this->mail->AddCC($copia, $nome);
            }
        }

        //define os ocultos
        if (!empty($emailOculto)) {
            foreach ($emailOculto as $nome => $copia) {
            $this->mail->AddBCC($copia, $nome);
            }
        }

        //Set the subject line
        $this->mail->Subject = $assunto;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $this->mail->msgHTML($html);

        //Replace the plain text body with one created manually
        $this->mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$this->mail->addAttachment('images/phpmailer_mini.png');
        if (!empty($nomeArquivo)) {
            // Opcional: Anexos
            $this->mail->AddAttachment($caminho . $nomeArquivo, $nomeArquivo);
        }
        /*
        //send the message, check for errors
        if (!$this->mail->send()) {
            echo "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
        //*/
    }

    public function send()
	{
        //send the message, check for errors
		/*
        if (!$this->mail->send()) {
		    echo "Mailer Error: " . $this->mail->ErrorInfo;
		} else {
		    echo "Message sent!";
		}//*/
		return $this->mail->send();

	}

}