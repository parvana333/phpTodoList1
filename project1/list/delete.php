<?php
include ("../create_con.php");
include ("../auth.php");
$sql1="SELECT * FROM worklist WHERE ID='". $_GET['id']."' ";
$result1=mysqli_query($conn,$sql1);
if(mysqli_num_rows($result1)>0){
    $row=mysqli_fetch_assoc($result1);
}
if($row['user_id']==$_SESSION['u_name']){
    $sql4="DELETE FROM worklist WHERE  ID='" . $_GET['id']."'";
    if(mysqli_query($conn,$sql4)){
        header( 'Location:list.php');
    }
    else{
        echo "did not executed";
    }
}

?>







