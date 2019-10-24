<?php
include ("create_con.php");
$email=null;
$username=null;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .redborder {
            border-color:red !important;
        }
        .blackborder{
            border-color:black;
        }
    </style>;

</head>
<?php
$error=array("username"=>null,"email"=>null,"password"=>null,"confirm"=>null);
if(isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['psw']);
    $confirm = mysqli_real_escape_string($conn, $_POST['psw1']);
    if (empty($username)) {
        $error["username"] = "fill";
    } else {
        if (!preg_match("/^[a-z]*$/", $username)) {
            $error["username"] = "invalid username";
        }
        else{
            $sql = "SELECT * FROM users where username='" . $username . "'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            $error["username"]="username exist";
                        }
        }
    }
    if (empty($email)) {
        $error["email"] = "fill";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error["email"] = "invalid email";
        }
        else{
            $sql1 = "SELECT * FROM users where email='" . $email . "'";
                            $result1 = mysqli_query($conn, $sql1);
                            if (mysqli_num_rows($result1) > 0) {
                                $error["email"]="email exists";
                            }

        }
    }
    if (empty($password)) {
        $error["password"] = "fill";
    } else {
        if (!preg_match("/^[a-z0-9]{6}$/", $password)) {
            $error["password"] = "invalid password";
        }
    }
    if (empty($confirm)) {
        $error["confirm"] = "fill";
    } else {
        if ($password != $confirm) {
            $error["confirm"] = "password does not match ";
        } else{
                $hashedPsw = password_hash($password, PASSWORD_DEFAULT);
                $sql2 = "Insert into users (username, password, email) values ('" . $username . "','" . $hashedPsw . "','" . $email . "')";
                mysqli_query($conn, $sql2);
                header("Location:index.php?signup=success");
            }
        }
}
?>
<body>
<div class="container">
    <br>
    <br>
    <div>
        <form  method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control <?= (isset($error["username"]) ) ? 'redborder' : ''  ?> " name="username" id="username"   value="<?=  $username ?>" placeholder="enter username">
                <p><?php echo $error["username"] ?></p>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control <?= (isset($error["email"]) ) ? 'redborder' : ''  ?> " name="email" id="email" value="<?=  $email ?>" placeholder="enter email">
                <p><?php echo $error["email"] ?></p>
            </div>
            <div class="form-group">
                <label for="psw">Password:</label>
                <input type="password" class="form-control <?= (isset($error["password"]) ) ? 'redborder' : ''  ?> " name="psw" id="psw" placeholder="Enter password">
                <p><?php echo $error["password"]?></p>
            </div>
            <div class="form-group">
                <label for="psw"> Confirm password:</label>
                <input type="password" class="form-control <?= (isset($error["confirm"]) ) ? 'redborder' : ''  ?> " name="psw1" id="psw1" placeholder="Rewrite password">
                <p><?php echo $error["confirm"]?></p>
            </div>
            <input type="submit" class="btn btn-primary" value="Sign up" name="signup">
            <br>
            <br>
            <p> Already registered? <a href="index.php">Log in</a></p>
        </form>
    </div>
</div>
</body>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
