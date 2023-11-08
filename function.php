<?php
require 'db.php';

function getmovie(){
    global $conn;
    $qry = "SELECT * FROM movie";
    $raw = mysqli_query($conn, $qry);
    if($raw){
        if(mysqli_num_rows($raw)>0){
            $res=mysqli_fetch_all($raw,MYSQLI_ASSOC);
            $data=[
                'status' =>200,
                'message' =>' movie found',
                'data' => $res
            ];
            header("HTTP/1.0 200 ok" );
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            $data=[
                'status' =>404,
                'message' =>'no movie found',
            ];
            header("HTTP/1.0 404 Internal server" );
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }
    else{
        $data=[
            'status' =>500,
            'message' => 'Method not allowed',
        ];
        header("HTTP/1.0 500 Internal server" );
        echo json_encode($data);
    }
}
?>