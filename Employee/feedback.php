<?php

@include '../database.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:emp_login.php');
};

if(isset($_POST['send'])){


   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

 $select_message = $conn->prepare("SELECT * FROM `feedback` WHERE email = ? AND msg = ?");
 $select_message->execute([$email, $msg]);

   if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      echo 'Please enter valid email';
   }
   else{

      $insert_message = $conn->prepare("INSERT INTO `feedback`(Emp_id, emailid,msg) VALUES(?,?,?)");
      $insert_message->execute([$user_id, $email, $msg]);

      echo '<script>alert("Feedback sent successfully!")</script>';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Feedback</title>
   <link rel="stylesheet" href="../CSS/feedback.css"/>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>




<?php
   $sql = "SELECT * FROM Employee WHERE Emp_id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$user_id]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   ?>
   

    
   <div class="container">
   <form action="" method="POST">
 <div class="label"><h2>Feedback  <img src="../CSS/feedback.png" width="30px" height="30px" ></h2></div>
 <input type="hidden" name="email" class="box" value="<?=$row['email_id']?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter valid Email" required placeholder="example@email.com">
  <div class="mb-32">
    <label for="exampleFormControlTextarea1" class="form-label"></label><br>
    <textarea class="form-control"  name="msg" id="exampleFormControlTextarea1" rows="7" cols="50"></textarea>
  </div>
  <div>
    
    <input type="submit" value="Send Feedback" class="btn" name="send">
  </div>
 
</form>
</div>












<script src="js/script.js"></script>

</body>
</html>