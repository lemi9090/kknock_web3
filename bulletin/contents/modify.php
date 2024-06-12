<?php
include "/var/www/html/db_conn.php";

if ($conn === false) {
    die("연결 실패: " . mysqli_connect_error());
}

