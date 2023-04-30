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
        $empid = $_POST['empid'];
        $empid = filter_var($empid,FILTER_SANITIZE_STRING);
        $fname = $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);
        $lname = $_POST['lname'];
        $lname = filter_var($lname,FILTER_SANITIZE_STRING);
        $emailid = $_POST['emailid'];
        $emailid = filter_var($emailid,FILTER_SANITIZE_STRING);
        $mobile = $_POST['mobile'];
        $mobile = filter_var($mobile,FILTER_SANITIZE_STRING);
        $fname = $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);
        
        $fname = $_POST['fname'];
        $fname = filter_var($fname,FILTER_SANITIZE_STRING);
        $photo = $_FILES['photo']['name'];
        $photo = filter_var($photo, FILTER_SANITIZE_STRING);
        $photo_size = $_FILES['photo']['size'];
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_folder = '../uploaded_img/'.$photo;
        $select = $conn->prepare("Select * from users where email_id = ?");
        $select->execute([$emailid]);
        $pass = rand(100000,999999);
        $Emp_check = $conn->prepare("Select * from users where Emp_id = ?");
        $Emp_check->execute([$empid]);
        $file_type=strtolower(pathinfo($photo,PATHINFO_EXTENSION));
        if($select->rowCount() > 0){
            echo "Employee with email already exist!!"; 
        }elseif($Emp_check->rowCount() > 0){
            echo "Employee with Employee ID already exist";
        }elseif($file_type!="jpg" && $file_type!="png" && $file_type!="jpeg" && $file_type!="webp") {
            echo "Only jpg,jpeg,png,webp are allowed";
        }
        else{
            
            $spass=$pass;
            $pass = password_hash($_POST['pass'],PASSWORD_DEFAULT,array('cost' => 9));
            $insert = $conn->prepare("Insert into Employee(Emp_id,First_name,Last_name,Mobile_no,email_id,Emp_photo,Password) VALUES(?,?,?,?,?,?,?)");
            $insert->execute([$empid,$fname,$lname,$mobile,$emailid,$photo,$pass]);
            move_uploaded_file($photo_tmp_name, $photo_folder);

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
            $mail->Body    = '<b>Sign in Now and avail the cubicles!!</b>
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
        $delete_cubicle = $conn->prepare("DELETE FROM Employee WHERE Emp_id = ?");
        $delete_cubicle->execute([$delete_id]);
        
        header('location:emp_reg.php');
     
     
     }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Registration</title>
        <!-- <link rel="stylesheet" href="../CSS/registration.css"> -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="../CSS/qfc-dark.css">
    </head>
    <body>
    <?php 
@include 'header.php';
?>

<div class="qfc-container">
    <h2>Registration</h2>
    
    <form action="" class="input-group" method="POST">
                     <input type="text" name="empid" class="input-field" placeholder="Employee ID" required>
                    <input type="text" class="input-field" name="fname" placeholder="First Name" required>
                    <input type="text" class="input-field" name="lname" placeholder="Last Name" required>
                    <input type="email" name="emailid"  class="input-field"  placeholder="Email ID" required/>
                    <input type="tel" name="mobile"  class="input-field"  placeholder="Mobile No" required/>
                    
                        <h6>Attach Employee Image</h6>
                        
                        <input type="file"  placeholder="Employee Image"class="input-field" required name="photo" accept="photo/jpg, photo/jpeg, photo/png, photo/webp " required/>
                    
                  
                    <input type="submit" name="sub" class="submit-btn" value="Register Employee"/>
                   
                    
                    <br>
                </form>
  </div>

     <!-- <div class="hero">
            <div class="form-box">   
                <div class="button-box">
                    <div id="btn"></div>
                    <button type="button" class="toogle-btn" onclick="register()">REGISTER</button>
                     <button type="button" class="toogle-btn" onclick="register()">REGISTER</button> 
                </div>
                <div class="social-icons">
                    <img src="../CSS/tw.png">
                    <img src="../CSS/gp.png">
                    <img src="../CSS/fb.png">
                </div>
                <form id="login" class="input-group" method="POST">
                     <input type="text" name="empid" class="input-field" placeholder="Employee ID" required>
                    <input type="text" class="input-field" name="fname" placeholder="First Name" required>
                    <input type="text" class="input-field" name="lname" placeholder="Last Name" required>
                    <input type="email" name="emailid"  class="input-field" class="input-field" placeholder="Email ID" required/>
                    <input type="tel" name="mobile"  class="input-field" class="input-field"  placeholder="Mobile No" required/>
                    <div>
                        <h6>Attach Employee Image</h6>
                        <div>
                        <input type="file" name="photo" placeholder="Employee Image"class="input-field" required  accept="photo/jpg, photo/jpeg, photo/png, photo/webp"/>
                        </div>
                      </div>
                    <input type="password" name="pass" placeholder="Password" class="input-field" required/>
                    <input type="password" name="cpass" placeholder="Confirm Password" class="input-field" required/>
                    <input type="submit" name="sub" class="submit-btn" value="Register Employee"/>
                   
                    
                    <br>
                </form> -->
               
            
<!--
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="empid" placeholder="Employee ID" required/>
        <input type="text" name="fname" placeholder="First Name" required/>
        <input type="text" name="lname" placeholder="Last  Name" required/>
        <input type="email" name="emailid" placeholder="Email ID" required/>
        <input type="tel" name="mobile"  placeholder="Mobile No" required/>
        <input type="file" name="photo" placeholder="Employee Image" required  accept="photo/jpg, photo/jpeg, photo/png, photo/webp"/>
        <input type="password" name="pass" placeholder="Password" required/>
        <input type="password" name="cpass" placeholder="Confirm Password" required/>
        <input type="submit" name="sub" value="Register Employee"/>
    </form>
    -->
    

<h1 class="title">View Registered Employees</h1>
<table class="table table-bordered border-primary table-light">
<tr>
    <th scope="col">Employee Photo</th>
      <th scope="col">Employee ID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email ID</th>
      <th scope="col">Mobile No</th>
      <th scope="col">Delete</th>
</tr>
    <?php
    $show_employee = $conn->prepare("SELECT * FROM Employee");
    $show_employee->execute();
    if($show_employee->rowCount() > 0){
        while($fetch_employee = $show_employee->fetch(PDO::FETCH_ASSOC)){  
    ?>
     <tr>
      
      <td> <img src="../uploaded_img/<?= $fetch_employee['Emp_photo']; ?>" alt="" height="20px" width="10px"></td>
      <td><?= $fetch_employee['Emp_id']; ?></td>
      <td> <?= $fetch_employee['First_name']; ?></td>
      <td> <?= $fetch_employee['Last_name']; ?></td>
      <td> <?= $fetch_employee['email_id']; ?></td>
      <td><?= $fetch_employee['Mobile_no']; ?></td>
      <td>  <a href="emp_reg.php?delete=<?= $fetch_employee['Emp_id']; ?>" class="delete-btn" onclick="return confirm('Delete this employee?');">Delete</a></td>
     
    </tr>

   
    <?php
    }
    }else{
        echo '<p class="empty">No employees added yet!</p>';
    }
    ?>
</table>
    </body>
</html>