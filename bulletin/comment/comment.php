<?php
include '../../db_conn.php';

if ($conn === false) {
    die("연결 실패: " . mysqli_connect_error());
}

$ppstm = $conn->prepare("INSERT INTO user(REF, ");

?>