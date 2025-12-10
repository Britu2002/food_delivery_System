<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

if (empty($_POST['token']) || $_POST['token'] != 'FsWga4&@f6aw') {
    echo '<span class="notice">Error!</span>';
    exit;
}

$name = $_POST['name'];
$from = $_POST['email'];
$phone = $_POST['phone'];
$subject = stripslashes(nl2br($_POST['subject']));
$message = stripslashes(nl2br($_POST['message']));

// Create email body
$body = "
    " . ucfirst($name) . " has sent you a message via contact form on your website!<br /><br />
    Name: " . ucfirst($name) . "<br />
    Email: $from<br />
    Phone: $phone<br />
    Subject: $subject<br />
    Message: $message<br /><br />
    ============================================================
";

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'd2002ora@gmail.com'; 
    $mail->Password   = 'rooe bxhs bkjd kdvg';   
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom($from, $name);
    $mail->addAddress('d2002ora@gmail.com');

	

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    echo '<div class="success"><i class="fas fa-check-circle"></i><h3>Thank You!</h3>Your message has been sent successfully.</div>';
} catch (Exception $e) {
    echo '<div>Your message sending failed! Mailer Error: ' . $mail->ErrorInfo . '</div>';
}
?>
