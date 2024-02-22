<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

function sendEmail($sendTo, $subject, $content)
{
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'dti6.mis@gmail.com';
    $mail->Password = 'yepzyaoulceepexj';
    $mail->SMTPSecure = 'tls';
    $mail->isHTML(true);
    $mail->setFrom('dti6.mis@gmail.com', 'MIS Administrator');
    $mail->addAddress($sendTo);
    $mail->AddBCC('angelopatrimonio@dti.gov.ph');
    $mail->AddBCC('bemyjohncollado@dti.gov.ph');
    $mail->AddBCC('dace.phage@gmail.com');
    $mail->Subject = $subject;
    $mail->Body = $content;
    $mail->send();
}
function validate($key, $conn)
{
    if (isset($_POST[$key]) && is_string($_POST[$key]) && trim($_POST[$key]) !== '') {

        return $conn->real_escape_string(htmlspecialchars(trim($_POST[$key]), ENT_QUOTES, 'UTF-8'));
    } else {
        return null;
    }
}

function encryptID($id, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

    $encrypted = openssl_encrypt($id, 'aes-256-cbc', $key, 0, $iv);

    return base64_encode($iv . $encrypted);
}

function decryptID($encrypted, $key)
{
    $encrypted = base64_decode($encrypted);

    $iv = substr($encrypted, 0, openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = substr($encrypted, openssl_cipher_iv_length('aes-256-cbc'));

    $decrypted = openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);

    return $decrypted;
}