<?php
    @include '../database.php';
    session_start();
    
    if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = $_POST['pass'];
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
     
       
        
        $sql = "SELECT * FROM `Admin` WHERE email_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $rowCount = $stmt->rowCount();  
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
     
        
     
        if($rowCount > 0){
     
         if(password_verify($pass,$row['Password'])){
              echo "login successful";
              $_SESSION['admin_id'] = $row['Admin_id'];
              header('location:admin_dashboard.php');
           }
           else{
              echo 'Invalid Details';
           }
        }else{
           echo 'Invalid Details!';
        }
     
     }
     
?>

<!DOCTYPE html>
<html lang="en">
    <head>

    <link rel="stylesheet" href="../CSS/dbms.css"/>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>

<div class="hero">
            <div class="form-box">   
                <div class="button-box">
                    <div id="btn"></div>
                    <button type="button" class="toogle-btn" onclick="login()">LOGIN</button>
                    <!-- <button type="button" class="toogle-btn" onclick="register()">REGISTER</button> -->
                </div>
                <div class="social-icons">
                    <img src="../CSS/tw.png">
                    <img src="../CSS/gp.png">
                    <img src="../CSS/fb.png">
                </div>
                <form id="login" action="" method="post" class="input-group">
                    <input type="email" class="input-field" name='email' placeholder="Enter Your Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required title="Please enter valid email" required>
                    <input type="password" name="pass" class="input-field" placeholder="Enter Password" required>
                    <a href="forgot_password.php" style="text-align: center;">Forgot password?</a>
                    <input type="submit" class="submit-btn" value="Login" class="btn" name="submit">
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
     
    </body>
</html>
