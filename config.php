<?php
    $server = 'localhost';
    $user = 'tvtumnvlhosting_canhan';
    $password='Hai2004@';
    $database='tvtumnvlhosting_canhanhoa';
    $conn=new mysqli($server, $user, $password, $database);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
?>