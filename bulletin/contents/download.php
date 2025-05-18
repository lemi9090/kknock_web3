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

$sql = "SELECT file_path FROM free_bulletin WHERE id = ?";
$ppstm = $conn->prepare($sql);
if (!$ppstm) {
    echo "DB 문제 발생: " . $conn->error;
    exit();
}

$ppstm->bind_param("i", $post_id); // 정수일 땐 i 
$ppstm->execute();
$result = $ppstm->get_result();
$file = $result->fetch_assoc();

if ($file && !empty($file['file_path'])) { // 파일 정보가 유효한지 확인
    $file_path = $file['file_path']; // file_path를 설정합니다.

    if (file_exists($file_path)) {
        ob_end_clean(); // 출력 버퍼 비우기
        ini_set('display_errors', 0); // 에러 출력 비활성화
        
        // MIME 타입 설정
        $extension = pathinfo($file_path, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'pdf':
                $contentType = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $contentType = 'image/jpeg';
                break;
            case 'png':
                $contentType = 'image/png';
                break;
            case 'txt':
                $contentType = 'text/plain';
                break;
            default:
                $contentType = 'application/octet-stream';
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        
        // 파일 내용 전송
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
