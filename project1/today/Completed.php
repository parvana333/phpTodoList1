<?php
include("../create_con.php");
include ("../auth.php");
 if(isset($_GET['id'])) {
     $sql = "SELECT * FROM worklist where ID='" . $_GET['id'] . "' and user_id='".$_SESSION['u_name']."'";
     $result = mysqli_query($conn, $sql);
     if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
             // add today's task to completed table
             $sql1 = "INSERT INTO COMPLETED (cname,ccategory,cdate,user_id) VALUES('" . $row['name'] . "','" . $row['category_name'] . "','" . $row['taskdate'] . "', '" .$row['user_id']. "')";
             $result1 = mysqli_query($conn, $sql1);
         }
// delete completed task from list table

             $sql2 = "DELETE FROM worklist WHERE ID='" . $_GET['id'] . "' and user_id='".$_SESSION['u_name']."'";
             mysqli_query($conn, $sql2);
     }
 }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Completed</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="../list/list.php">Tasks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../categories/categories.php">Categories</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../search/search.php">Search</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="today.php">Today's tasks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Completed.php" style="color:red">Completed tasks</a>
        </li>
    </ul>
    <h class="display-2">Completed task</h>
    <br>
    <br>
    <?php
    // write to screen from completed
    $sql3="select * from completed where user_id='".$_SESSION['u_name']."'";
    $result3=mysqli_query($conn,$sql3);
    if(mysqli_num_rows($result3)>0){
        echo '<table class="table">
        <thead class="table-dark">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>category_name</th>
            <th>date</th>
            <th>Revert</th>
        </tr>
        </thead>
        <tbody>';
    }
    while($row3=mysqli_fetch_assoc($result3)){
        echo'<tr>
            <td> '.$row3["id"].'</td>
            <td> '.$row3["cname"].'</td>
            <td> '.$row3["ccategory"].'</td>
            <td> '.$row3["cdate"].'</td> 
            <form action="" method="post">
            <td><button type="submit"  name="revert" class="btn btn-primary" value="'.$row3["id"].'">revert</button></td>
            </form>
            </tr>';
    }
     echo '</tbody>
    </table>';

    // if task is not completed revert it to worklist table
    if(isset($_POST['revert'])){
        $value=$_POST['revert'];
        $sql4="SELECT * from completed where id='".$value."' and user_id='".$_SESSION['u_name']."'";
        $result4=mysqli_query($conn,$sql4);
        if(mysqli_num_rows($result4)>0){
            $row4=mysqli_fetch_assoc($result4);
            $sql5="INSERT INTO worklist (name,category_name, taskdate,user_id) values ('".$row4['cname']."','".$row4['ccategory']."','".$row4['cdate']."','".$row4['user_id']."')";

        }
            mysqli_query($conn,$sql5);
            $sql6="DELETE FROM completed where id='".$value."' and user_id='".$_SESSION['u_name']."'";
               if( mysqli_query($conn,$sql6)){
               header('Location:Today.php');
               }
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
