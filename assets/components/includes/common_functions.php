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
    if (isset($_POST[$key])) {
        if (is_string($_POST[$key])) {
            $value = trim($_POST[$key]);
            if ($value !== '') {
                return $conn->real_escape_string($value);
            }
        }
    }

    return null;
}

function encryptID($id, $key)
{
    // Generate a random initialization vector (IV) using the key
    $iv = substr(md5($key), 0, 16);

    // Encrypt the ID using AES encryption in CBC mode
    $encrypted = openssl_encrypt($id, 'AES-256-CBC', $key, 0, $iv);

    // Encode the encrypted data to make it URL-safe
    $safeEncoded = base64_encode($encrypted);

    // Split the encoded string into five parts of four characters each
    $chunks = str_split($safeEncoded, 4);

    // Join the chunks with "-"
    return implode('-', $chunks);
}

function decryptID($encrypted, $key)
{
    // Split the encrypted string into chunks separated by "-"
    $chunks = explode('-', $encrypted);

    // Concatenate the chunks
    $safeEncoded = implode('', $chunks);

    // Decode the URL-safe encoded string
    $encrypted = base64_decode($safeEncoded);

    // Generate the initialization vector (IV) using the key
    $iv = substr(md5($key), 0, 16);

    // Decrypt the data using AES decryption in CBC mode
    $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);

    return $decrypted;
}
