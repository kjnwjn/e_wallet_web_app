<?php
require_once('./private/core/phpmailer/PHPMailer.php');
require_once('./private/core/phpmailer/SMTP.php');
require_once('./private/core/phpmailer/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Util
{
    public function checkTimeStamp($timeStamp = null)
    {
        return ((string) (int) $timeStamp === $timeStamp)
            && ($timeStamp <= PHP_INT_MAX)
            && ($timeStamp >= ~PHP_INT_MAX);
    }
    public function checkValidImage($image = null)
    {
        return ($image['type'] === 'image/jpeg' || $image['type'] === 'image/png' || $image['type'] === 'image/jpg');
    }
    public function checkName($name)
    {
        return preg_match("/^[a-zA-Z-' ]*$/", $name);
    }
    public function checkEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public function checkPhoneNumber($phoneNumber)
    {
        return preg_match("/^[0-9]{10}$/", $phoneNumber);
    }

    public function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function uploadImage($imageToUpload)
    {

        // Được rồi
        // thêm cái hex gì à
        // thằng var_dum để show ra mà
        // giống vs print_r á
        $id_token = bin2hex(random_bytes(10));
        $target_dir = "./public/assest/img/uploads/";
        $target_file = $target_dir . $id_token . basename($imageToUpload["name"]);

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image

        $check = getimagesize($imageToUpload["tmp_name"]);
        if ($check == false) {
            return [
                'status' => false,
                'msg' => 'File is not an image.'
            ];
        } else if (file_exists($target_file)) {
            return [
                'status' => false,
                'msg' => 'Sorry, file already exists.'
            ];
        } else if ($imageToUpload["size"] > 500000) {
            return [
                'status' => false,
                'msg' => 'Sorry, your file is too large.'
            ];
        } else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            return [
                'status' => false,
                'msg' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.'
            ];
        } else {

            if (move_uploaded_file($imageToUpload["tmp_name"], $target_file)) {
                return [
                    'status' => true,
                    'path' => $target_file,
                    'msg' => 'The file ' . htmlspecialchars(basename($imageToUpload['name'])) . ' has been uploaded.'
                ];
            } else {
                return [
                    'status' => false,
                    'msg' => "Sorry, there was an error uploading your file."
                ];
            }
        }
    }

    public function sendMail($username, $password, $email)
    {

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            $mail->isSMTP(); // gửi mail SMTP
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = '3puz627rgnyn6m@gmail.com'; // SMTP username
            $mail->Password = '*2!3!!J$t%%#e%'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587; // TCP port to connect to
            //Recipients
            $mail->setFrom('3puz627rgnyn6m@gmail.com', 'Mailer');
            // $mail->addAddress('joe@example.net', 'Joe User'); // Add a recipient
            $mail->addAddress($email); // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
            // Content
            $mail->isHTML(true);   // Set email format to HTML
            $mail->Subject = 'Here is your username and password for KiWi_APP';
            $mail->Body = '<html>
                                <body>
                                    <h1>Account Details</h1>
                                    <h2>Thank you for registering on our site, your account details are as follows:</h2>
                            
                                    <p>Username: ' . $username . '</p>
                            
                                    <p>Password: ' . $password . '</p>
                                </body>
                            </html>';
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
