<?php
    @include '../database.php';
    session_start();

    $admin_id = $_SESSION['admin_id'];
    
    if(!isset($admin_id)){
       header('location:admin_login.php');
    };
    
    if(isset($_GET['delete'])){

        echo "<script>alert('Delete this Booking??')</script>";
        $delete_id = $_GET['delete'];
        $delete_booking = $conn->prepare("DELETE FROM booking WHERE booking_id = ?");
        $delete_booking->execute([$delete_id]);
        
        header('location:admin_booking.php');     
     }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

        <title>Booking-details</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    <?php 
  @include 'header.php';
  ?>   
    <section class="c">
    <h1 class="title">Booking List</h1>


    

    
    


    </div>

<div class="box-container">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Booking id</th>
      <th scope="col">Employee id</th>
      <th scope="col">Username</th>
      <th scope="col">Start</th>
      <th scope="col">End</th>
    </tr>
  </thead>

<?php
   $show_booking = $conn->prepare("SELECT * FROM `booking`");
   $show_booking->execute();
   if($show_booking->rowCount() > 0){
      while($fetch_booking = $show_booking->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
<tr>
      
      <td><?= $fetch_booking['Booking_ID']; ?></td>
      <td><?= $fetch_booking['Emp_ID']; ?></td>
      <td><?= $fetch_booking['Start_Time']; ?></td>
      <td><?= $fetch_booking['End_Time']; ?></td>
      <td> <a href="admin_booking.php?delete=<?= $fetch_booking['Booking_ID']; ?>" class="delete-btn" onclick="return confirm('delete this cubicle?');">Delete</a></td>
    </tr>

</div>
<?php
   }
}else{
   echo '<p class="empty">No Bookings yet!</p>';
}
?>
</tbody>
</table>
<br><br>
<h1 >Employee - Assigned Cubicles </h1>
<table class="table">
  <thead class="thead-dark">
    <tr>
    
      <th scope="col">Cubicle no</th>
      <th scope="col">Room</th>
      <th scope="col">Employee Name</th>
    </tr>
  </thead>
<br>

<?php
   $show_booking = $conn->prepare("SELECT First_name,Last_name,cubicle_no,room FROM Employee e 
   join Booking b on b.Emp_id=e.Emp_id
   join Cubicle c on b.Cubicle_ID=c.cubicle_id");
   $show_booking->execute();
   if($show_booking->rowCount() > 0){
      while($fetch_booking = $show_booking->fetch(PDO::FETCH_ASSOC)){  
?>

<tbody>
    <tr>
      
      <td> <?= $fetch_booking['cubicle_no']; ?></td>
      <td><?= $fetch_booking['room']; ?></td>
      <td> <?= $fetch_booking['First_name']; ?>  <?= $fetch_booking['Last_name']; ?></td>
      
    </tr>

   
<?php
   }
}else{
   echo '<p class="empty">No Bookings yet!</p>';
}
?>
 </tbody>
</table>


</div>

</section>
    </section>
    </body>
</html>
