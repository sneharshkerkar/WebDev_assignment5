<?php

@include 'database.php';

session_start();
session_unset();
session_destroy();

header('location:Employee/emp_login.php');

?>