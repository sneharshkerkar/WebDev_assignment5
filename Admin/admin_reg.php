<?php
    @include '../database.php';
    session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};
    use PHPMailer\PHPMailer\PHPMailer;
    require_once __DIR__ . '/../vendor/autoload.php';
    
    use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['sub'])){
        $adminid = $_POST['adminid'];
        $adminid = filter_var($adminid,FILTER_SANITIZE_STRING);
        $uname = $_POST['uname'];
        $uname = filter_var($uname,FILTER_SANITIZE_STRING);
        $emailid = $_POST['emailid'];
        $emailid = filter_var($emailid,FILTER_SANITIZE_STRING);
        $mobile = $_POST['mobile'];
        $mobile = filter_var($mobile,FILTER_SANITIZE_STRING);
        $_POST['pass']=rand(100000,999999);
        $pass=$_POST['pass'];
        $select = $conn->prepare("Select * from admin where email_id = ?");
        $select->execute([$emailid]);

        $Admin_check = $conn->prepare("Select * from Admin where Admin_id = ?");
        $Admin_check->execute([$adminid]);
        if($select->rowCount() > 0){
            echo "Admin with email already exist!!"; 
        }elseif($Admin_check->rowCount() > 0){
            echo "Employee with Employee ID already exist";
        }
        else{
            
            $spass=$pass;
            $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT,array('cost' => 9));
            $insert = $conn->prepare("Insert into Admin(Admin_id,Username,Mobile_no,email_id,Password) VALUES(?,?,?,?,?)");
            $insert->execute([$adminid,$uname,$mobile,$emailid,$pass]);
            echo "Successfully Added";

            $mail = new PHPMailer(true);
            try{
            $mail->isSMTP();                                          
            // Enable SMTP authentication
                         
            
            $mail->Username='cubiteam813@gmail.com';
            $mail->Password='kjzgcztyndspmtap';
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';                                  // TCP port to connect to
         
            //Recipients
            $mail->setFrom('cubiteam813@gmail.com','CubiTeam');
            $mail->addAddress($_POST['emailid']);
         
         
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Heres your credentials';
            $mail->Body    = '<b>Sign in Now Admin and Manage cubicles!!</b>
            <p>Email => '.$emailid.'</p>
            <p>Password => '.$spass.'</p>
            <p>with regards</p>
            <p>CubiTeam</p>';
            $mail->AltBody = 'From CubiTeam';
            echo "<script>alert('Mail sent');</script>";
            $mail->send();  
        } catch (Exception $e) {
            echo "<script>alert('Check your network connection');</script>";
        }
        require "../vendor/autoload.php";
        
        }
        
        
    }

    if(isset($_GET['delete'])){

        echo "<script>alert('Delete this Employee??')</script>";
        $delete_id = $_GET['delete'];
        $delete_cubicle = $conn->prepare("DELETE FROM Admin WHERE Admin_id = ?");
        $delete_cubicle->execute([$delete_id]);
        
        header('location:admin_reg.php');
     
     
     }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin Registration</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="../CSS/qfc-dark.css">
       
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    </head>
    <body>
    <?php include 'header.php'; ?>
    <div class="qfc-container">
    <h2>Admin Registration</h2>
    <form method="POST" enctype="multipart/form-data">
      <div>
       
        <div>
        <p>Admin ID
             <input type="text" name="adminid" placeholder="Admin ID" required/>
        </div>
        </p>
        <div>
          <p>Username
         <input type="text" name="uname" placeholder="Username" required/>
        </p>
        </div>
        <div>
          <p>Email ID
          <input type="email" name="emailid" placeholder="Email ID" required/>
          </p>
          </div>
       

          <div>
          <p>Mobile No
          <input type="tel" name="mobile"  placeholder="Mobile No" required/>
               </p>
          </div>
               
          <div>
          <p>Password
          <input type="hidden" name="pass" value="" required/>
               </p>
          </div>


        <div>
          <button type="submit"  name="sub">Add Admin</button>
        </div>
      </div>
    </form>
  </div>

   



  
    <div class="box-container">
     
    <table class="table" style="color:white;">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Admin id</th>
      <th scope="col">Username</th>
      <th scope="col">Mobile no</th>
      <th scope="col">Email</th>
    </tr>
  </thead>
<br>
        <?php
        $show_admin = $conn->prepare("SELECT * FROM Admin where email_id!='saishsawant25102001@gmail.com'");
        $show_admin->execute();
        if($show_admin->rowCount() > 0){
            while($fetch_admin = $show_admin->fetch(PDO::FETCH_ASSOC)){  
        ?>


<tbody>
    <tr>
      
      <td> <?= $fetch_admin['Admin_id']; ?></td>
      <td><?= $fetch_admin['Username']; ?></td>
      <td> <?= $fetch_admin['Mobile_no']; ?></td>
      <td> <?= $fetch_admin['email_id']; ?></td>
      <td> <a href="admin_reg.php?delete=<?= $fetch_admin['Admin_id']; ?>" class="delete-btn" onclick="return confirm('Delete this employee?');">Delete</a></td>
    </tr>

        

        
        </div>
        <?php
        }
        }else{
            echo '<p class="empty">No employees added yet!</p>';
        }
        ?>
     </tbody>
</table>

</div>
   
</body>
</html>