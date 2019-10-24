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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
       <title>Document</title>
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
            <a class="nav-link" href="search.php" style="color:red">Search</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../today/today.php">Today's tasks</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../today/Completed.php">Completed tasks</a>
        </li>
    </ul>
    <h1  class="display-4">Search for task</h1>
    <form action="" method="post" >
        <div class="row">
            <div class="col-2">
        <input  class="form-control" type="text" name="task" placeholder="search task..">
            </div>
            <div class="col-2">
        <select name="categories" class="custom-select">
            <option value="" disabled selected >category</option>
            <?php
            $sql3 = "SELECT * FROM categorylist where user_id='".$_SESSION['u_name']."'";
            $result1 = mysqli_query($conn, $sql3);
            if(mysqli_num_rows($result1)>0){
                while($row=mysqli_fetch_assoc($result1)){
                    echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
                }
            }
            ?>
        </select>
            </div>
            <div class="col-2">
                <input type="submit" class="btn btn-primary" name="submit" value="search">
            </div>

    </form>
    <br>
    <br>
    <br>
        <?php
        if(isset($_POST['submit'])){
                if (empty($_POST['task']) && !empty($_POST['categories'])){
                    $categoryname=$_POST['categories'];
                    $sql4 = "SELECT name,category_name from worklist WHERE category_name='" . $categoryname . "' and user_id='".$_SESSION['u_name']."' ";
                }
                elseif (empty($_POST['task']) && empty($_POST['categories'])){
                $sql4 = "SELECT name,category_name from worklist where user_id='".$_SESSION['u_name']."'";
                }
                elseif(!empty($_POST['task']) && !empty($_POST['categories'])) {
                    $taskname = $_POST['task'];
                    $categoryname=$_POST['categories'];
                    $sql4 = "SELECT name,category_name from worklist WHERE name  Like '%" . $taskname . "%'  and category_name='" . $categoryname ."' and user_id='".$_SESSION['u_name']."'";
                }
                elseif (empty($_POST['categories']) && !empty($_POST['task'])){
                    $taskname = $_POST['task'];
                    $sql4 = "SELECT name,category_name from worklist WHERE name  Like '%" . $taskname . "%' and user_id='".$_SESSION['u_name']."'";
                }
                $result1 = mysqli_query($conn, $sql4);
                if (mysqli_num_rows($result1) > 0) {
                    echo '<table class="table">
                          <thead class="table-dark">
                          <tr>
                          <th>task_name</th>
                          <th>category_name</th>
                          </tr>
                         </thead>
                         <tbody>';
                    while ($row2 = mysqli_fetch_assoc($result1)) {
                        echo '
                          <tr>
                          <td>' . $row2["name"] . '</td>
                          <td>' . $row2["category_name"] . '</td>
                          </tr>
                           ';
                    }
                    echo '   </tbody>
                             </table>';
                }
        }
        ?>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
