<?php
    @include '../database.php';
    session_start();

$admin_id = $_SESSION['admin_id'];

if(isset($_GET['delete'])){

    echo "<script>alert('Delete this Feedback??')</script>";
    $delete_id = $_GET['delete'];
    $delete_cubicle = $conn->prepare("DELETE FROM Feedback WHERE fid = ?");
    $delete_cubicle->execute([$delete_id]);
    
    header('location:view_feedback.php');
 
 
 }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

        <title>View Feedback</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
     
<?php 
@include 'header.php';
?>
<div class="box-container">

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Feedback id</th>
      <th scope="col">Email</th>
      <th scope="col">Message</th>
    </tr>
  </thead>


<?php
   $show_feedback = $conn->prepare("SELECT * FROM Feedback");
   $show_feedback->execute();
   if($show_feedback->rowCount() > 0){
      while($fetch_feedback = $show_feedback->fetch(PDO::FETCH_ASSOC)){  
?>



<tbody>
    <tr>
      
      <td><?= $fetch_feedback['fid']; ?></td>
      <td><?= $fetch_feedback['emailid']; ?></td>
      <td> <?= $fetch_feedback['msg']; ?></td>
      <td> <a href="admin_reg.php?delete=<?= $fetch_admin['Admin_id']; ?>" class="delete-btn" onclick="return confirm('Delete this employee?');">Delete</a></td>
    </tr>



   
  
   
   
</div>
<?php
   }
}else{
   echo '<p class="empty">No cubicle added yet!</p>';
}
?>
 </tbody>
</table>
</div>

</section>
    </section>
    </body>
</html>