<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/vendor/autoload.php';

    use PHPMailer\PHPMailer\Exception;


 if(isset($_POST['sub'])){ 
    $mail = new PHPMailer(true);
    try{
    $mail->isSMTP();                                          
    // Enable SMTP authentication
                 
    
 $mail->Username='bookingcubicle@gmail.com';
 $mail->Password='ermziwddglizphfn';
    $mail->Host='smtp.gmail.com';
    $mail->Port=587;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure='tls';                                  // TCP port to connect to
 
    //Recipients
    $mail->setFrom('fresh27823@gmail.com','Download pdf');
    $mail->addAddress($_POST['email']);
 
 
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Heres the bill';
    $mail->Body    = '<b>Download Bill!</b>
    <p>with regards</p>
    <p>Fresh Veggies';
    $mail->AltBody = 'From Fresh Veggies';
    echo "<script>alert('Check your mail bill has been sent');</script>";
    $mail->send();  
} catch (Exception $e) {
    echo "<script>alert('Check your network connection');</script>";
}
require "vendor/autoload.php";

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form  method="post">
        <input type="email" name="email" required>
        <input type="submit" name="sub">
    </form>
</body>
</html>