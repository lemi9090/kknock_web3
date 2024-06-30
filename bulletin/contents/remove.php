<?php
include '/??/???/??/db_conn.php';

session_start();

if (!isset($_SESSION['name'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href='../../index.php';</script>";
    exit();
}

$username = $_SESSION['name'];
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!isset($_SESSION['board_id'])) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit();
}

$board_id = $_SESSION['board_id'];

if ($post_id == 0) {
    echo "<script>alert('잘못된 접근입니다.'); history.back();</script>";
    exit();
}

// SQL 쿼리 준비
$sql = "DELETE FROM free_bulletin WHERE id = ? AND board_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $post_id, $board_id);
$stmt->execute();

$alertMessage = ($stmt->affected_rows > 0) ? "게시물이 성공적으로 삭제되었습니다." : "게시물 삭제 실패: 게시물을 찾을 수 없거나 접근 권한이 없습니다.";

$location = '';
switch ($board_id) {
    case 1:
        $location = '../free_bulletin.php';
        break;
    case 2:
        $location = '../new_bulletin.php';
        break;
    default:
        $location = '../dictionary.php';
        break;
}

$stmt->close();
$conn->close();

echo "<script>alert('$alertMessage'); window.location.href='$location';</script>";
exit();
?>
