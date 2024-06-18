<?php

include '../../db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../../index.php';</script>";
    exit();
}

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit();
}

$sql = "SELECT file_path from free_bulletin where id = ?";
$ppstm = $conn->prepare($sql);
if (!$ppstm) {
    echo "DB 문제 발생: " . $conn->error;
    exit();
}
$ppstm->bind_param("i", $post_id);//정수일 땐 i 
$ppstm->execute();
$result = $ppstm->get_result();
$file = $result->fetch_assoc();                                    

if ($file && !empty($file['file_path'])) {
    $file_path = $file['file_path']; // 파일 경로 확인
   
    if (file_exists($file_path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        exit;
    } else {
        echo "파일을 찾을 수 없습니다.";
    }
} else {
    echo "해당 게시물의 파일 정보를 찾을 수 없습니다.";
}

$ppstm->close();
$conn->close();
?>




