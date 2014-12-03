<?

namespace helpers\mail;

class MailHelper {

    public static function welcome($playername, $password, $email, $email_ip = false) {


        $mail = new \PHPMailer();

        $mail->IsSMTP(true); // send via SMTP

        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->SMTPDebug = 0;    // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;    // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = PHPMAILER_USERNAME; // SMTP username
        $mail->Password = PHPMAILER_PASSWORD; // SMTP password
        $webmaster_email = PHPMAILER_EMAIL; //Reply to this email ID

        $name = $playername; // Recipient's name
        $mail->From = $webmaster_email;
        $mail->FromName = "Comunidade Minecraft Portugal";
        $mail->AddAddress($email,$name);
        $mail->WordWrap = 50; // set word wrap
        $mail->IsHTML(true); // send as HTML

        $mail->Subject = "Comunidade Minecraft Portugal: Registo!";
        $body = file_get_contents(WEB_ROOT . "/templates/email/registo.html");
        $body = str_replace('$playername', $playername, $body);
        $body = str_replace('$password', $password, $body);

        if ($email_ip) {
            $body = str_replace('$ip', $_SERVER['REMOTE_ADDR'], $body);
        } else {
            $body = str_replace('$ip', "Server Administrator", $body);
        }
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body); //Text Body

        if(!$mail->Send()) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }
    }
}

?>
