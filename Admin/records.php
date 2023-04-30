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
        $delete_booking = $conn->prepare("DELETE FROM records WHERE rec_id = ?");
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
    <h1 class="title">Records</h1>


    

    
    


    </div>

<div class="box-container">
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Record ID</th>
      <th scope="col">Cubicle ID</th>
      <th scope="col">Employee ID</th>
      <th scope="col">Start Time</th>
      <th scope="col">End Time</th>
    </tr>
  </thead>

<?php
   $show_booking = $conn->prepare("SELECT * FROM records");
   $show_booking->execute();
   if($show_booking->rowCount() > 0){
      while($fetch_booking = $show_booking->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
<tr>
      
      <td><?= $fetch_booking['rec_id']; ?></td>
      <td><?= $fetch_booking['cubicle_id']; ?></td>
      <td><?= $fetch_booking['Emp_ID']; ?></td>
      <td><?= $fetch_booking['Start_Time']; ?></td>
      <td><?= $fetch_booking['End_Time']; ?></td>
      
    </tr>

</div>
<?php
   }
}else{
   echo '<p class="empty">No Records yet!</p>';
}
?>
</tbody>
</table>
<br><br>

    </section>
    </body>
</html>