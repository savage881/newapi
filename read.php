<?php
header('Access-Control-Allow-Origin:*');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Method: Content-type,Access-Control,Allow-Control,Authorization,X-Request-with');

include('function.php');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['q'])) {
        $q = $_GET['q'];
        $qry = "SELECT * FROM movie WHERE title LIKE '%$q%' OR overview LIKE '%$q%'";
    } else {
        $qry = "SELECT * FROM movie";
    }
    $raw = mysqli_query($conn, $qry);
    $data = array();
    while ($res = mysqli_fetch_array($raw)) {
        $data[] = $res;
    }
    print(json_encode($data));
}
else{
$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod == "GET"){
$Movie=getmovie();
echo $Movie;
}
else
{
    $data=[
        'status' =>405,
        'message' =>$requestMethod. 'Methhod not allowed',
    ];
    header("HTTP/1.0 405 Method not allowed" );
    echo json_encode($data);
}
}
?>