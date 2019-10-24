<?php
session_start();
if(!isset($_SESSION['u_name'])){
header("Location:http://localhost:8081/Todolist/project1/index.php");
exit();
}


