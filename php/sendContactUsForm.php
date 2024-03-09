<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer files manually (adjust the path as needed)
require $_SERVER['DOCUMENT_ROOT'] . '/php/phpMailer/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/php/phpMailer/SMTP.php';
require $_SERVER['DOCUMENT_ROOT'] . '/php/phpMailer/Exception.php';
// private data
$config = include '../../config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
// require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


// Get form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'N/A';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'N/A';
$phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : 'N/A';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : 'N/A';


try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $config['mail_host'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = $config['mail_auth'];                                 //Enable SMTP authentication
    $mail->Username   = $config['mail_username'];                      //SMTP username
    $mail->Password   = $config['mail_password'];                                 //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $config['mail_port'];                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($config['mail_from'] , 'CPC - Contact Us Form');
    $mail->addAddress($config['mail_to']);    //Add a recipient  //Name is optional
    $mail->addAddress($config['mail_to'], 'Joe User');     //Add a recipient        
    $mail->addReplyTo($config['mail_reply'] , 'CPC - Calgary Palestinian Council');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'CPC - Contact Us Form';
    $mail->Body = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            html{
                font-family: 'Arial', sans-serif;
                background-color: #fff;
                color: #000;
                padding: 20px;
                margin: 0;
                width: 100%;
                max-width: 900px;
            }
            body {
                font-family: 'Arial', sans-serif;
                background-color: #fff;
                color: #000;
                padding: 20px;
                margin: 0;
                width: 100%;
                max-width: 900px;
            }

            header {
                background-color: #009351;
                color: #fff;
                text-align: center;
                padding: 10px;
                width: 100%;
                max-width: 900px;
            }
            .cpc {
                color: #fff;
            }
            .logo-header {
                width: 100%;
                max-width: 900px;
                text-align: center;
            }

            .logo {
                width: 500px;
                max-width:  500px;
                height: auto;
            }

            h2 {
                width: 100%;
                max-width: 900px;
                color: #009351;
                text-align: center;
            }

            p {
                width: 100%;
                max-width: 800px;
                text-align: left;
                margin-bottom: 10px;
                margin-left: 100px;
            }

            strong {
                font-weight: bold;
                color: #DB372B;
            }
        </style>
    </head>
    <body>
        <header>
            <span class='cpc'>Calgary Palestinian Council (CPC)</span>
        </header>
        <div class='logo-header'>
        <img class='logo' src='https://calgarypalestiniancouncil.ca/img/cpcLogoWhiteBackground.jpg' alt='CPC Logo'>
        </div>
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Message:</strong> $message</p>
    </body>
    </html>
";


// Plain text alternative for clients that don't support HTML
$mail->AltBody = "
    Contact Form Submission

    Name: $name
    Email: $email
    Phone: $phone
    Message: $message
";
    $mail->send();
     // Redirect with success message
     header("Location:https://calgarypalestiniancouncil.ca/index.html?status=success#contact_us");
     exit;
} catch (Exception $e) {
   // Redirect with error message
   header("Location: https://calgarypalestiniancouncil.ca/index.html?status=error#contact_us");
   exit;
}
}else{
    // Redirect with error message
    header("Location: https://calgarypalestiniancouncil.ca/index.html?status=error#contact_us");
    exit;
}
?>