<?php
include ("../create_con.php");
include ("../auth.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
            <a class="nav-link" href="today.php" style="color:red">Today's tasks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Completed.php">Completed tasks</a>
        </li>
    </ul>
    <h class="display-2">Today's task</h>
    <br>
    <br>
    <?php
    $currentdate=date('Y-m-d');
    $sql="Select * from worklist where taskdate='".$currentdate."' and user_id='".$_SESSION['u_name']."'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0){
        echo '<table class="table"> 
                  <thead class="table-dark">
                  <tr>
                  <th>id</th>
                  <th>name</th>
                  <th>category_name</th>
                  <th>date</th>
                  <th>Completed</th>
                  </tr>
                  </thead>
                  <tbody>';
        while($row=mysqli_fetch_assoc($result)){
            echo
                ' 
                  <tr>
                  <td>'.$row["ID"].'</td>
                  <td>'.$row["name"].'</td>
                  <td>'.$row["category_name"].'</td>
                  <td>'.$row["taskdate"].'</td>
                  <form action="Completed.php" method="get">
                  <td><a href="Completed.php ? id='.$row["ID"].'" class="btn btn-primary">Done</a></td>
                  </form>
                  </tr>
                  ';
        }
        echo '   </tbody>
                 </table>';
    }
    ?>
    <!-- when click done delete from everywhere insert to completed.php -->
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>
