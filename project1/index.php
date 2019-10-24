
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <style>
    .redborder {
    border-color:red !important;
    }
    </style>;

</head>
<body>
<?php
if(isset($_SESSION['u_name'])){
    header("Location:http://localhost:8081/Todolist/project1/list/list.php");
    exit();
}
session_start();
include "create_con.php";
$error=array("username"=>null,"password"=>null);
if(isset($_POST['login'])){
    $loguser=mysqli_real_escape_string($conn,$_POST['username']);
    $logpass=mysqli_real_escape_string($conn,$_POST['psw']);
    if(empty($logpass)){
        $error["password"]="fill the password ";
    }
    if(empty($loguser)){
        $error["username"]="fill the username ";
    }
    else {
        $sql = "select * from users where username='" . $loguser . "'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) < 1) {
            $error["username"] = "incorrect username";
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                $dehashpsw = password_verify($logpass, $row['password']);
                if ($dehashpsw == false) {
                    $error["password"] = "incorrect password";
                } elseif ($dehashpsw == true) {
                    // Log in the user
                    $_SESSION['u_name'] = $row['user_id'];
                    header("Location:list/list.php");
                }
            }
        }
    }
}

?>
<div class="container">
    <br>
    <br>
 <div>
    <form action="index.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text"  class="form-control <?= isset($error["username"]) ? 'redborder' : '' ?>" name="username" id="username" placeholder="Enter username" >
            <span class="a"><?php echo $error["username"] ?></span>
        </div>
        <div class="form-group">
            <label for="psw">Password:</label>
            <input type="password" class="form-control <?= isset($error["password"]) ? 'redborder' : '' ?>" " name="psw" id="psw" placeholder="Enter password">
             <p><?php echo $error["password"] ?> </p>
        </div>
        <input type="submit" class="btn btn-primary" name="login" value="Log in">
        <br>
        <br>
        <p> Not yet registered? <a href="registration.php">Register</a></p>
    </form>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
