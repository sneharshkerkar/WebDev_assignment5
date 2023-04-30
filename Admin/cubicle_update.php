<?php

@include '../database.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};



if(isset($_POST['update_cubicle'])){

   $cubicle_id = $_POST['cubicle_id'];
  // $cubicle_id = filter_var($cubicle_id, FILTER_SANITIZE_STRING);
   $room = $_POST['room'];
   $room = filter_var($room, FILTER_SANITIZE_STRING);
   $cubicle_no = $_POST['cn'];
   $cubicle_no = filter_var($cubicle_no, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   

   $update_cubicle = $conn->prepare("UPDATE cubicle SET room = ?, cubicle_no = ?, status = ? WHERE cubicle_id = ?");
   $update_cubicle->execute([$room, $cubicle_no , $status, $cubicle_id]);

   echo '<script>alert("Cubicle Updated Successfully!");</script>';

 
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Cubicle</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="shortcut icon" type="image/png" href="images/logo.png"/>
   
   <link rel="stylesheet" href="../CSS/qfc-dark.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="update-cubicle">

   <h1 class="title">Update Cubicle</h1>   

   <?php
      $update_id = $_GET['update'];
      $select_cubicle = $conn->prepare("SELECT * FROM cubicle WHERE cubicle_id = ?");
      $select_cubicle->execute([$update_id]);
      if($select_cubicle->rowCount() > 0){
         while($fetch_cubicle = $select_cubicle->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   
   <div class="qfc-container">
    <h2>Update Cubicle</h2>
    
    <form method="POST" enctype="multipart/form-data">
      <div>
       
        <div>
        <p>Cubicle ID
            <input placeholder="Cubicle ID" name="cubicle_id"  value="<?= $fetch_cubicle['cubicle_id']; ?>"  type="text" readonly>
        </div>
        </p>
        <div>
          <p>Room
        <select name="room"  placeholder="Room" required>
               <option value="<?= $fetch_cubicle['room']; ?>"><?= $fetch_cubicle['room']; ?></option>
               <option value="A">A (Individual)</option>
               <option value="B">B (Team of 3)</option>
               <option value="C">C (Team of 5)</option>
               </select> </p>
        </div>
        <div>
          <p>Cubicle No
            <input name="cn" placeholder="Cubicle number" value="<?= $fetch_cubicle['cubicle_no']; ?>"  type="number"  id="Test_DatetimeLocal">
          </p>
          </div>
       

          <div>
          <p>Status
         

               <select name="status" placeholder="Status" required>
               <option value="<?= $fetch_cubicle['status']; ?>" ><?= $fetch_cubicle['status']; ?></option>
               <option value="Available">Available</option>
               <option value="Not Available">Not Available</option>
               </select>
               </p>
          </div>
               


        <div>
        <button type="submit"   name="update_cubicle">Update Cubicle</button>
        </div>
      </div>
    </form>
    <?php
         }
      }else{
         echo '<p class="empty">No Cubicles Found!</p>';
      }
   ?>
  </div>


   </body>
   </html>