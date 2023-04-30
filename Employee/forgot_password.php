<?php
    @include '../database.php';
    session_start();


    use PHPMailer\PHPMailer\PHPMailer;
    require_once __DIR__ . '/../vendor/autoload.php';
    
        use PHPMailer\PHPMailer\Exception;

?>
<!doctype html>
<html lang="en">
<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


    <link rel="stylesheet" href="../CSS/dbms.css"/>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="shortcut icon" type="image/png" href="images/logo.png"/>

    <title>Forgot Password</title>
</head>
<body>

  
  

  <div class="hero">
            <div class="form-box">   
                <div class="button-box">
                    <div id="btn"></div>
                    <button type="button" class="toogle-btn" onclick="login()">Forgot Password</button>
                    <!-- <button type="button" class="toogle-btn" onclick="register()">REGISTER</button> -->
                </div>
                <div class="social-icons">
                    <img src="../CSS/tw.png">
                    <img src="../CSS/gp.png">
                    <img src="../CSS/fb.png">
                </div>
                <form id="login" action="" method="post" class="input-group">
                    <input type="email" class="input-field" name='email' placeholder="Enter Your Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required title="Please enter valid email" required>
                    <br><br>
                    <input type="submit" value="Recover" class="submit-btn" name="recover"> 
                </form>
                <!-- <form id="register" class="input-group">
                    <input type="text" class="input-field" placeholder="User Id" required>
                    <input type="email" class="input-field" placeholder="Email Id" required>
                    <input type="text" class="input-field" placeholder="Enter Password" required>
                    <input type="checkbox" class="checkbox"><span>I agree to the terms and conditions</span>
                    <button type="sumbit" class="submit-btn">Register</button>
                </form> -->
                </div>
            </div>
</section>
<?php
 if(isset($_POST['recover'])){

        $email = $_POST["email"];

        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
            );
       
           $expDate = date("Y-m-d H:i:s",$expFormat);
        $sql = "SELECT * FROM Employee WHERE email_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $rowCount = $stmt->rowCount();


        if($rowCount != 1){
            ?>
            <script>
                alert("<?php  echo "Sorry, no email exists "?>");
            </script>
           <?php
        }else{
            $token = bin2hex(random_bytes(50));

            $update = $conn->prepare("UPDATE Employee set token = ?, exp_date=? WHERE email_id = ?");
            $update->execute([$token,$expDate, $email]);
        $mail = new PHPMailer(true);
        try{
        $mail->isSMTP();                                          
        // Enable SMTP authentication
                     
        
        $mail->Username='cubiteam813@gmail.com';
        $mail->Password='kjzgcztyndspmtap';
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';                                  // TCP port to connect to
     
        //Recipients
        $mail->setFrom('cubiteam813@gmail.com','CubiTeam');
        $mail->addAddress($_POST['email']);
     
     
        // Content
        $url="http://localhost/DBMS_Project/Employee";
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Heres your credentials';
        $mail->Body    = "<b>Dear User</b>
        <h3>We received a request to reset your password.</h3>
        <p>Kindly click the below link to reset your password</p>
        <p><a href='".$url."/recover.php?key=".$email."&token=".$token."'>Click To Reset password</a></p>
        <br><br>
        <p></p>
        <b>From CubiTeam</b>";
        $mail->AltBody = 'From CubiTeam';
        echo "<script>alert('Mail sent');</script>";
        $mail->send();  
    } catch (Exception $e) {
        echo "<script>alert('Check your network connection');</script>";
    }
    require "../vendor/autoload.php";
    
    }
}

?>



</body>
</html>
<?php
?>