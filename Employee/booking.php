<?php
    @include '../database.php';
    session_start();

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:emp_login.php');
    };

    if(isset($_POST['sub'])){
        
       
        $cid = $_POST['cid'];
        $cid = filter_var($cid,FILTER_SANITIZE_STRING);
        $s_time = $_POST['stime'];
        $s_time = filter_var($s_time,FILTER_SANITIZE_STRING);
        $e_time = $_POST['etime'];
        $e_time = filter_var($e_time,FILTER_SANITIZE_STRING);
        date_default_timezone_set('Asia/Kolkata');
        $date = date('d-m-y h:i:s');

       

        $n_check = $conn->prepare("Select * from Booking where  Emp_id = ?");
        $n_check->execute([$user_id]); 

        $c_check = $conn->prepare("Select b.cubicle_id  from Booking b join Cubicle c on b.cubicle_id = c.Cubicle_ID");
        $c_check->execute();
        
        if($n_check->rowCount() > 0){
            echo "Your Booking already exist";
        }elseif($c_check->rowCount() > 0){
          echo "Cubicle already booked";
        }elseif($s_time>=$e_time){
            echo "Invalid End Time";
        }else{
            $insert = $conn->prepare("Insert into Booking(Emp_ID,Cubicle_ID,Start_Time,End_Time) VALUES(?,?,?,?)");
            $insert->execute([$user_id,$cid,$s_time,$e_time]);

            $record = $conn->prepare("Insert into Records(Emp_ID,Cubicle_ID,Start_Time,End_Time) VALUES(?,?,?,?)");
            $record->execute([$user_id,$cid,$s_time,$e_time]);
            echo "<script>alert('Successfully Added')</script>";
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
    
        <title>Booking</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../CSS/qfc-dark.css">
    </head>
    <body>
    <?php
    @include 'header.php';   
    ?>
    <div class="qfc-container">
    <h2>BOOKING</h2>
    <label>Book Your Space</label>
    <form method="POST" action="">
      <div>
       
        <div>
            <input placeholder="Cubicle ID" name="cid"  type="text" required>
        </div>
        <div>
          <p>Start Date
          <input placeholder="Start Date and Time" type="datetime-local" name="stime" id="Test_DatetimeLocal">
        </p>
        </div>
        <div>
          <p>End Date
            <input placeholder="End Date and Time" type="datetime-local"  name="etime" id="Test_DatetimeLocal">
          </p>
          </div>
       
        <div>
          <button type="submit"  name="sub">Submit</button>
        </div>
      </div>
    </form>
  </div>
</body>

<!--

        <section class="add">
            
    
    <form method="POST" enctype="multipart/form-data">
        
        <input type="text" name="empid" placeholder="Employee ID" required/>
        <input type="text" name="cid" placeholder="Cubicle ID" required/>
        <input type="datetime-local" name="stime" placeholder="Start Time" required>
        <input type="datetime-local" name="etime" placeholder="End Time" required>
        <input type="submit" name="sub" value="Book"/>
    </form>
    </section>

    -->
    

<div class="box-container">
<table class="table table-bordered border-primary table-light">
<tr>
      <th scope="col">Cubicle ID</th>
      <th scope="col">Cubicle No</th>
      <th scope="col">Room</th>
      <th scope="col">Status</th>
     
    </tr>

<?php
   $show_cubicle = $conn->prepare("SELECT * FROM `cubicle` where status='Available'");
   $show_cubicle->execute();
   if($show_cubicle->rowCount() > 0){
      while($fetch_cubicle = $show_cubicle->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
   
   <tr>
      
      <td><?= $fetch_cubicle['cubicle_id']; ?></td>
      <td><?= $fetch_cubicle['cubicle_no']; ?></td>
      <td> <?= $fetch_cubicle['room']; ?></td>
      <td> <?= $fetch_cubicle['status']; ?></td>
      
      
    </tr>

  
</div>
<?php
   }
}else{
   echo '<p class="empty">No cubicle added yet!</p>';
}
?>

</div>
<div class="box-container">

<?php
   $show_booking = $conn->prepare("SELECT room,cubicle_no FROM Cubicle where status='Available'");
   $show_booking->execute();
   if($show_booking->rowCount() > 0){
      while($fetch_booking = $show_booking->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
   <div class="">Booking ID: <?= $fetch_booking['room']; ?></div>
   <div class="">Cubicle No: <?= $fetch_booking['cubicle_no']; ?></div>
  
  
  
</div>
<?php
   }
}else{
   echo '<p class="empty">No Bookings yet!</p>';
}
?>

</div>

</section>
    </section>
    </body>
</html>