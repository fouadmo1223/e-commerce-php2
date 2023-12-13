<?php



//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../mail/autoload.php';

// unique otp 

function sendOTP($num, $targetedEmail, $message) {
    $mail = new PHPMailer();

    // Compose the email body based on the message type
    if ($message === "otp") {
        $body = "Dear User,<br><br>Your One-Time Password (OTP) to verify your email address is: <span style='font-size: 18px; font-weight: bold;'>$num</span><br><br>Best regards,<br>E-commerce Team";
    } else if($message == 'password') {
        $body = "Dear User,<br><br>Your password is: $num<br><br>Best regards,<br>E-commerce Team";
    }else{
        $body = "Dear User,<br><br>$message<br><br>Best Wishes,<br>E-commerce Team";
    }

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'fm0850020@gmail.com';
    $mail->Password = 'aaxj imge yjtz motx'; // Replace with your actual password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Additional email settings
    $mail->isHTML(true);
    $mail->CharSet = "UTF-8";
    $mail->setFrom('fm0850020@gmail.com', 'E-commerce');
    $mail->addAddress($targetedEmail);
    $mail->Subject = 'Verification Information';
    $mail->Body = $body;

    // Send the email
    if ($mail->send()) {
        $response = array("status" => "success", "message" => "Email has been sent successfully.");
    } else {
        $response = array("status" => "error", "message" => "Email could not be sent. Error: " . $mail->ErrorInfo);
    }

    return $response;
}



?>