<?php
include '../../db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../../index.php';</script>";
    exit();
}

if (isset($_SESSION['board_id'])) {
    $boardid = $_SESSION['board_id']; //세션값 게시판 선택
  }
  
  if (isset($_SESSION['post_id'])) {
    $post_id = $_SESSION['post_id']; // 세션값에서 게시물 선택 
  }


// SQL 쿼리 준비
$sql = "DELETE FROM free_bulletin WHERE id = ? AND board_id = ?";
$stmt = $conn->prepare($sql);

// SQL 쿼리 실행
$stmt->bind_param("ii", $post_id, $board_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo '<script>alert("게시물이 성공적으로 삭제되었습니다.");</script>';
    echo '<script>history.back();</script>';
} else {
    echo '<script>alert("게시물 삭제 실패: 게시물을 찾을 수 없거나 접근 권한이 없습니다.");</script>';
    echo '<script>history.back();</script>';
}

$stmt->close();
$conn->close();
?>