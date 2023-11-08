<?php
$conn = mysqli_connect("localhost", "root", "");
mysqli_select_db($conn, "shortsapi");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        $qry = "SELECT * FROM shorts WHERE title LIKE '%$q%' OR desc LIKE '%$q%'";
    } else {
        $qry = "SELECT * FROM shorts";
    }
    $raw = mysqli_query($conn, $qry);
    $data = array();
    while ($res = mysqli_fetch_array($raw)) {
        $data[] = $res;
    }
    print(json_encode($data));
} else {
    $qry = "SELECT * FROM shorts";
    $raw = mysqli_query($conn, $qry);
    $data = array();
    while ($res = mysqli_fetch_array($raw)) {
        $data[] = $res;
    }
    print(json_encode($data));
}
?>


