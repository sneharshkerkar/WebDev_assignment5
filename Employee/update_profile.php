<?php

@include '../database.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:emp_login.php');
};

if(isset($_POST['update_profile'])){

   $fname = $_POST['fname'];
   $fname = filter_var($fname, FILTER_SANITIZE_STRING);
   $lname = $_POST['lname'];
   $lname = filter_var($lname, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $mobile = $_POST['mobile'];
   $mobile = filter_var($mobile, FILTER_SANITIZE_STRING);
  


   $sql = "SELECT * FROM Employee WHERE Emp_ID = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$user_id]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);



  
   $update_pass = $_POST['update_pass'];
   $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
   $new_pass = $_POST['new_pass'];
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = $_POST['confirm_pass'];
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;
   $old_image = $_POST['old_image'];
   $imageFileType = strtolower(pathinfo($image,PATHINFO_EXTENSION));

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($new_pass != $confirm_pass){
         echo 'Password Does Not Matched';
      }
      elseif(password_verify($update_pass,$row['Password'])){
        if(!empty($image)){
            if($image_size > 2000000){
               echo  'image size is too large!';
            }elseif($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"  && $imageFileType != "webp"){
               echo 'Only jpg, jpeg, webp & png image formats are allowed';
            }
            else{
      
               $update_image = $conn->prepare("UPDATE Employee SET Emp_photo = ? WHERE Emp_ID = ?");
               $update_image->execute([$image, $user_id]);
      
               if($update_image){
                  move_uploaded_file($image_tmp_name, $image_folder);
                  unlink('uploaded_img/'.$old_image);
                  echo  'Image updated successfully!';
               }
            }
         }

         $confirm_pass = password_hash($_POST['confirm_pass'],PASSWORD_DEFAULT, array('cost' => 9));
         $update_pass_query = $conn->prepare("UPDATE Employee SET  First_name = ?, Last_name = ?, email = ?,mobile = ?, password = ? WHERE Emp_id = ?");
         $update_pass_query->execute([$fname, $lname, $email, $mobile, $confirm_pass, $user_id]);
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
   <title>CubiTeam Update User Profile</title>

   <!-- font awesome cdn link  -->
   
 
   <link rel="stylesheet" href="../CSS/registration1.css">

</head>
<body>
   
<?php include 'header.php'; ?>




   <h1 class="title">Update Profile</h1>
 <?php
      $select_profile = $conn->prepare("SELECT * FROM Employee WHERE Emp_ID = ?");
      $select_profile->execute([$user_id]);
      if($select_profile->rowCount() > 0){
         while($fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC)){ 
   ?>
    <div class="hero">
            <div class="form-box">
            <div class="scroll-div">   
                <div class="button-box">
                    <div id="btn"></div>
                    <button type="button" class="toogle-btn" onclick="register()">Update Profile</button>
                    <!-- <button type="button" class="toogle-btn" onclick="register()">REGISTER</button> -->
                </div>
                <div class="social-icons">
                    <img src="../CSS/tw.png">
                    <img src="../CSS/gp.png">
                    <img src="../CSS/fb.png">
                </div>
                <img src="../uploaded_img/<?= $fetch_profile['Emp_photo']; ?>"  class="img" alt="Error" height="100px" width="100px"/> 
                <form id="login" class="input-group" method="POST">
                <input type="hidden" name="old_image" value="<?= $fetch_profile['Emp_photo']; ?>" required>
                 <input type="hidden" name="eid" value="<?= $fetch_profile['Emp_ID']; ?>" >

                <div class="update">
                   <input type="text" name="fname" value="<?= $fetch_profile['First_name']; ?>" placeholder="Enter First Name" required class="input-field">
                   <input type="text" name="lname" value="<?= $fetch_profile['Last_name']; ?>" placeholder="Enter Last Name" required class="input-field">
                   <input type="tel" name="mobile" value="<?= $fetch_profile['Mobile_no']; ?>" placeholder="Update Mobile Number" title="Enter valid mobile number" required pattern="[0-9]{10}" class="input-field">
                   <input type="email" name="email" value="<?= $fetch_profile['email_id']; ?>" placeholder="Update Email" title="Enter valid email" required class="input-field">
                   <input type="password" name="update_pass" placeholder="Enter Current Password" class="input-field" required>
                  <input type="password" name="new_pass" placeholder="Enter New Password"  class="input-field" required>
                  <input type="password" name="confirm_pass" placeholder="Confirm New Password" class="box" required><br>
                  <label style="font-size:17px;color:black;">Update Image?? (Optional)</label>
               <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp"  class="input-field" value=" ">
               </div>
               <input type="submit" class="btn" value="Update Profile" name="update_profile">

               </div>
         </div>
         
                 
                </form>
               
                </div>
            </div>

   <?php
         }
      }else{
         echo '<p class="empty">No Employee Found!</p>';
      }
   ?>



<?php include '../footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>