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

function generateEncryptionKey($length = 32)
{
    return bin2hex(random_bytes($length));
}

// Function to encrypt data
function encryptData($data, $key)
{
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decryptData($encryptedData, $key)
{
    $data = base64_decode($encryptedData);
    $iv = substr($data, 0, 16);
    $encrypted = substr($data, 16);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}

function verifyCaptcha($recaptchaResponse, $secretKey)
{
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    );

    $options = array(
        'http' => array(
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $responseData = json_decode($response, true);
    return $responseData['success'];
}