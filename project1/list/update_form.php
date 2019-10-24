<?php
include ("../create_con.php");
include ("../auth.php");
$sql5="SELECT * from worklist where ID='".$_GET['id']."'";
$result=mysqli_query($conn,$sql5);
if(mysqli_num_rows($result)>0){
    $row=mysqli_fetch_assoc($result);
}

if(isset($_POST['submit'])) {
    $key=$_POST['hidden'];
    $sql5="SELECT * from worklist where ID='".$key."'";
    $result=mysqli_query($conn,$sql5);
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
    }
    if (!empty($_POST['name'])||!empty($_POST['categoryname'])) {
        $updatedName = $_POST['name'];
        $updatedcategory=$_POST['categoryname'];
        $taskdate=$_POST['date'];
        if($row['user_id']==$_SESSION['u_name']){
            $sql6 = "UPDATE worklist SET  name='".$updatedName."',category_name='".$updatedcategory."',taskdate='".$taskdate."' WHERE ID='".$key."'";
            if (mysqli_query($conn, $sql6)) {
                header( 'Location:list.php');
            }
            else{
                echo "did not execute";
            }
        }

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Update</title>
</head>
<body>
<div class="container">
<h1 class="course-heading">update</h1>
<form action=" " method="post">

    <div class="form-group">
    <label for="name">Task:</label>
    <input type="text" name="name"   value="<?php echo $row['name'] ?>" class="form-control" id="name">
    </div>
    <div class="form-group">
        <label for="name">Category:</label>
        <select name="categoryname" class="custom-select">
            <option selected><?php echo $row['category_name'] ?></option>
            <?php
            $sql_c = "SELECT * FROM categorylist where user_id='".$_SESSION['u_name']."'";
            $result_c = mysqli_query($conn, $sql_c);
            if(mysqli_num_rows($result_c)>0){
                while($row2=mysqli_fetch_assoc($result_c)){
                    echo '<option value="'.$row2["name"].'">'.$row2["name"].'</option>';
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input class="form-control" type="date" name="date" value="<?php echo $row['taskdate'] ?>" id="date1">
    </div>
    <div class="form-group">
    <input type="submit" name="submit"  class="btn btn-primary" value="update">
    </div>
   <input type="hidden" name="hidden" value="<?php echo $_GET['id'] ?>">

</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</div>
</body>
</html>


