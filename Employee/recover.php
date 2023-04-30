<?php session_start() ;

@include '../database.php';

?>


<!doctype html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


<link rel="stylesheet" href="css/components.css">
<link rel="shortcut icon" type="image/png" href="images/logo.png"/>
   
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    

    <title>Recover</title>
</head>
<body>
<section class="form-container">
<?php

if ($_GET['key'] && $_GET['token']) {
    

    $email = $_GET['key'];
    $token = $_GET['token'];

    echo ".$email.";
    echo ".$token.";

    $select_users = $conn->prepare("SELECT * FROM Employee WHERE email_id = ? and token = ?");
    $select_users->execute([$email,$token]);
    $rowCount = $select_users->rowCount();  

   $row = $select_users->fetch(PDO::FETCH_ASSOC);

$curDate = date("Y-m-d H:i:s");

if($rowCount > 0)
{ 
    if($curDate <= $row['exp_date']){ ?>
<form action="" enctype="multipart/form-data" method="POST">
   <h3>Recover Password</h3>
   <input type="hidden" name="email" value="<?php echo $email; ?>">
   <input type="hidden" name="token" value="<?php echo $token; ?>">
   <input type="password" name="pass" class="box" placeholder="Enter Your Password" required>
   <input type="password" name="cpass" class="box" placeholder="Confirm Your Password" required>
   <input type="submit" value="Recover Password" class="btn" name="reset">
</form>
<?php }
}else
    {               echo "This forget password link has been expired!<script>window.open('link_expired.html','_self')</script>";
              }
            }?>
</section>
</body>
</html>
<?php
  
    if(isset($_POST["token"]) && $_POST["pass"] && $_POST["email"]){
          
      $pass = $_POST['pass'];
      $pass = filter_var($pass, FILTER_SANITIZE_STRING);
      $cpass = $_POST['cpass'];
      $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
      $curDate = date("Y-m-d H:i:s");

        $token = $_POST['token'];
        $Email = $_POST['email'];

        
     

        $sql = "SELECT * FROM Employee WHERE email_id = ? AND token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$Email,$token]);
        $rowCount = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);



        if($pass=$cpass){
         $null="null";
         if($rowCount == 1)
         {
         $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT, array('cost' => 9));
         $change_pass_query = $conn->prepare("UPDATE Employee SET password =?, token= ?,exp_date=? WHERE email_id=? ");
         $change_pass_query->execute([$pass,$null,$null,$Email]);
         echo "<script>alert('Password changed Successfully!');</script>";
         
         echo "<script>window.open('emp_login.php','_self')</script>";
            ?>
            <?php
        }else
        {
            echo "<script>alert('Something went wrong please try again');</script>";
        }
    }
        else
        {
            ?>
            <script>
                alert("<?php echo "Password does not match"?>");
            </script>
            <?php
        }
    }

?>