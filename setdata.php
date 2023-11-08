<?php
$conn=mysqli_connect("localhost","root","");
mysqli_select_db($conn, "apidb");

$name=$_POST['name'];
$email=$_POST['email'];

$qry="INSERT INTO `tbl_user`(`id`, `name`, `email`) VALUES ('null','$name','$email')";

$res=mysqli_query($conn,$qry);
if ($res==true)
$response="inserted";
else
$response="failed";

echo json_encode($response);

$qry="select * from tbl_staff";
$raw=mysqli_query($conn, $qry);
while ($res=mysqli_fetch_array($raw))
{
$data[]=$res;
}
print(json_encode($data));
?>