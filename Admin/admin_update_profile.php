<?php

@include '../database.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_profile'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $mobile = $_POST['mobile'];
   $mobile = filter_var($mobile, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE Admin SET Username = ?, email_id = ?, Mobile_no = ? WHERE Admin_id = ?");
   $update_profile->execute([$name, $email,$mobile, $admin_id]);

   $sql = "SELECT * FROM Admin WHERE admin_id = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$admin_id]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   
   

   $update_pass = $_POST['update_pass'];
   $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
   $new_pass = $_POST['new_pass'];
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = $_POST['confirm_pass'];
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($new_pass != $confirm_pass){
         echo 'Password Does Not Matched!';
      }
      elseif(password_verify($update_pass,$row['Password'])){
         $confirm_pass = password_hash($_POST['confirm_pass'],PASSWORD_DEFAULT, array('cost' => 9));
         $update_pass_query = $conn->prepare("UPDATE `admin` SET  Username = ?, email_id = ?,Mobile_no=?,Password = ? WHERE admin_id = ?");
         $update_pass_query->execute([$name, $email,$mobile, $confirm_pass, $admin_id]);
         echo 'Profile Updated Successfully!';
      }
      else{
         echo "Current password does not match";
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Admin Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../CSS/qfc-dark.css">

</head>
<body>
<?php 
@include 'header.php';
?>   


<section class="update-profile">


   <?php
      $select_profile = $conn->prepare("SELECT * FROM Admin WHERE Admin_id = ?");
      $select_profile->execute([$admin_id]);
      if($select_profile->rowCount() > 0){
         while($fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC)){ 
   ?>
<div class="qfc-container">
    <h2>Update Profile</h2>
    
    <form method="POST" enctype="multipart/form-data">
      <div>
       
        <div>
        <p>Username
        <input type="text" name="name" value="<?= $fetch_profile['Username']; ?>" placeholder="update username" required >
        </div>
        </p>
        <div>
          <p>Email
          <input type="email" name="email" value="<?= $fetch_profile['email_id']; ?>" title="Enter valid email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="update email" required>
         </p>
        </div>
        <div>
          <p>Mobile No
          <input type="tel" name="mobile" value="<?= $fetch_profile['Mobile_no']; ?>" title="Enter valid Mobile No" required pattern="[0-9]{10}" placeholder="update mobile no" required>
          </p>
          </div>
       

          <div>
          <p>Current Password
          <input type="password" name="update_pass" placeholder="Enter previous password" required >
               </p>
          </div>
          
          <div>
          <p>New Password
          <input type="password" name="new_pass" placeholder="Enter new password" required >
          </p>
          </div>

          <div>
          <p>Confirm Password
          <input type="password" name="confirm_pass" placeholder="Confirm new password" required >
          </p>
          </div>

        <div>
          <button type="submit"  name="sub">Add Cubicle</button>
        </div>
      </div>
    </form>
  </div>
   <
   <?php
         }
      }else{
         echo '<p class="empty">No Employee Found!</p>';
      }
   ?>

</section>

</body>
</html>