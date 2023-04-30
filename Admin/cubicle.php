<?php
    @include '../database.php';
    session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};
    if(isset($_POST['sub'])){
        $cid = $_POST['cid'];
        $cid = filter_var($cid,FILTER_SANITIZE_STRING);
        $room = $_POST['room'];
        $room = filter_var($room,FILTER_SANITIZE_STRING);
        $cn = $_POST['cn'];
        $cn = filter_var($cn,FILTER_SANITIZE_STRING);
        $status = $_POST['status'];
        $status = filter_var($status,FILTER_SANITIZE_STRING);
       
        $select = $conn->prepare("Select * from cubicle where cubicle_id = ?");
        $select->execute([$cid]);

        $n_check = $conn->prepare("Select * from users where  cubicle_no = ?");
        $n_check->execute([$cn]);
        if($select->rowCount() > 0){
            echo "Cubicle with ID already exist!!"; 
        }elseif($n_check->rowCount() > 0){
            echo "Cubicle with Number already exist";
        }else{
            $insert = $conn->prepare("Insert into cubicle(cubicle_id,room,cubicle_no,status) VALUES(?,?,?,?)");
            $insert->execute([$cid,$room,$cn,$status]);
            echo "Successfully Added";
        }
        
    };

    if(isset($_GET['delete'])){

        echo "<script>alert('Delete this Cubicle??')</script>";
        $delete_id = $_GET['delete'];
        $delete_cubicle = $conn->prepare("DELETE FROM cubicle WHERE cubicle_id = ?");
        $delete_cubicle->execute([$delete_id]);
        
        header('location:cubicle.php');
     
     
     }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../CSS/qfc-dark.css">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body>
    <?php 
@include 'header.php';
?>
    <div class="qfc-container">
    <h2>ADD Cubicle</h2>
    
    <form method="POST" enctype="multipart/form-data">
      <div>
       
        <div>
        <p>Cubicle ID
            <input placeholder="Cubicle ID" name="cid"  type="text" required>
        </div>
        </p>
        <div>
          <p>Room
        <select name="room"  placeholder="Room" required>
       
               <option value="A">A (Individual)</option>
               <option value="B">B (Team of 3)</option>
               <option value="C">C (Team of 5)</option>
               </select> </p>
        </div>
        <div>
          <p>Cubicle No
            <input name="cn" placeholder="Cubicle number"  type="number"  id="Test_DatetimeLocal">
          </p>
          </div>
       

          <div>
          <p>Status
          <select name="status"  placeholder="Status" required>
       
               <option value="Available">Available</option>
               <option value="Not Available">Not Available</option>
               </select>
               </p>
          </div>
               


        <div>
          <button type="submit"  name="sub">Add Cubicle</button>
        </div>
      </div>
    </form>
  </div>

      


    
    <h1 class="title" style="color:white">Update Cubicle</h1>

<div class="box-container">
<table class="table table-bordered border-primary table-light">
<tr>
      <th scope="col">Cubicle ID</th>
      <th scope="col">Cubicle No</th>
      <th scope="col">Room</th>
      <th scope="col">Status</th>
      <th scope="col">Update</th>
      <th scope="col">Delete</th>
    </tr>

<?php
   $show_cubicle = $conn->prepare("SELECT * FROM `cubicle`");
   $show_cubicle->execute();
   if($show_cubicle->rowCount() > 0){
      while($fetch_cubicle = $show_cubicle->fetch(PDO::FETCH_ASSOC)){  
?>
    <tr>
      
      <td><?= $fetch_cubicle['cubicle_id']; ?></td>
      <td><?= $fetch_cubicle['cubicle_no']; ?></td>
      <td> <?= $fetch_cubicle['room']; ?></td>
      <td> <?= $fetch_cubicle['status']; ?></td>
      <td> <a href="cubicle_update.php?update=<?= $fetch_cubicle['cubicle_id']; ?>" class="option-btn">Update</a></td>
      <td>  <a href="cubicle.php?delete=<?= $fetch_cubicle['cubicle_id']; ?>" class="delete-btn" onclick="return confirm('delete this cubicle?');">Delete</a></td>
    </tr>



<?php
   }
}else{
   echo '<p class="empty">No cubicle added yet!</p>';
}
?>
</table>
</div>

</section>
    </section>
    </body>
</html>