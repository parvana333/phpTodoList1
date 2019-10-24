<?php
include ("../auth.php");
include ("../create_con.php");
if(isset($_POST['login'])){
    '<p>Welcome</p>';
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['name']) && !empty($_POST['categories'])) {
        header("Location:list.php?list=success");
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $category_name=$_POST['categories'];
        $taskdate=$_POST['date'];
        $sql1 = "INSERT INTO worklist(name,category_name,taskdate,user_id) VALUES (?,?,?,?);";
        $stmt=mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql1)){
            echo "sql eror";
        }
        else{
            mysqli_stmt_bind_param($stmt,"sssi",$name,$category_name,$taskdate,$_SESSION['u_name']);
            mysqli_stmt_execute($stmt);
        }
    }
    else {
        header("Location:list.php?list=empty");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<ul class="nav">
    <li class="nav-item">
    <a class="nav-link" href="list.php" style="color:red">Tasks</a>
    </li>
    <li class="nav-item">
    <a class="nav-link" href="../categories/categories.php">Categories</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../search/search.php">Search</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../today/today.php">Today's tasks</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../today/Completed.php">Completed tasks</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../index.php"> Log out </a>
    </li>

</ul>

<h1 class="course-heading" class="display-1">Tasks</h1>
<form action="" method="post">
     <div class="row">
         <div class="col-md-2">
    <input type="text" class="form-control" name="name" >
         </div>
         <div class="col-md-2">
             <select name="categories" class="custom-select">
                 <option selected>category</option>
                 <?php
                 $sql3 = "SELECT * FROM categorylist where user_id='".$_SESSION['u_name']."'";
                 $result1 = mysqli_query($conn, $sql3);
                 if(mysqli_num_rows($result1)>0){
                     while($row=mysqli_fetch_assoc($result1)){
                         echo '<option >'.$row["name"].'</option>';
                     }
                 }
                 ?>
             </select>
         </div>
         <div class="col-md-3">
             <input type="date" class="form-control" name="date">
         </div>
         <div class="col-md-1">
    <input type="submit" class="btn btn-primary" name="submit" value="Add">
         </div>
     </div>
    <br>
</form>

<table class="table table-bordered">
    <thead class="table-dark">
    <tr>
        <th >id  </th>
        <th>name  </th>
        <th>category_name</th>
        <th>date</th>
        <th> delete</th>
        <th>update</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql3 = "SELECT * FROM worklist  where user_id='".$_SESSION['u_name']."'";
    $result1 = mysqli_query($conn, $sql3);
    if(mysqli_num_rows($result1)>0){
        while ($row = mysqli_fetch_assoc($result1)){
            echo '<tr>
            <td align="center">'.$row["ID"].'</td>
            <td align="center">'.$row["name"].'</td>';
           echo '<td > '.$row["category_name"].'</td>';
           echo '<td > '.$row["taskdate"].'</td>';
           echo '<form action="delete.php" method="get">
            <td> <a   href="delete.php? id='. $row["ID"].'" class="btn btn-primary">delete</a></td>
             </form>
            <form action="update_form.php" method="get">
            <td> <a   href="update_form.php? id='. $row["ID"].'" class="btn btn-primary">update</a></td>
           
            </form>
        </tr>';
        }
    }?>
    </tbody>
</table>
<?php
$fullUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(strpos($fullUrl,"list=empty")==true){
    echo "<p>you did not fill name</p>";
}
elseif (strpos($fullUrl,"list=success")==true){

}

?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</div>
</body>
</html>
